<?php

namespace App\Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auditlog\Models\Auditlog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ManageAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'permission:' . User::PERMISSION_ADMIN,
        ]);
    }

    /**
     * List view
     *
     * @param Request $request
     * @return Response content
     */
    public function index(Request $request)
    {
        return view('account::manage-account.index', []);
    }

    /**
     * List view - datatable ajax call
     *
     * @param Request $request
     * @return Response json encoded data
     */
    public function grid(Request $request)
    {
        $search = (object) [];

        if (isset($request->search['value'])) {
            $search->q = $request->search['value'];
        }

        $req = User::search($request->input('start'), $request->input('length'), $request->input('order'), $search);
        $data = $req->data
            ->map(function ($item) {
                $item->status = User::$STATUS_LABELS[$item->status];
                return $item;
            });

        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $req->ttl,
            'iTotalDisplayRecords' => $req->ttl,
            'recordsFiltered' => count($data),
        ]);
    }

    /**
     * Detail view
     *
     * @param Request $request
     * @param $id
     * @return Response content
     */
    public function view(Request $request, $id = null)
    {
        if (!$id) {
            $model = new User(['status' => User::STATUS_ACTIVE]);
        } else {
            $model = User::findOrFail($id);
        }

        return view('account::manage-account.view', [
            'model' => $model,
        ]);
    }

    /**
     * Process form
     *
     * @param Request $request
     * @return Response
     */
    public function process(Request $request, $id = null)
    {
        $myself = $request->user();

        $model = User::find($id);
        if (empty($model)) {
            $model = new User();
            $isCreate = true;
        } else {
            $isCreate = false;
        }

        $validatorRules = [
            'name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users,email,' . $model->id . ',id',
            'status' => 'required|integer',
            'roles' => 'required',
        ];
        $this->validate($request, $validatorRules);

        DB::transaction(function () use (&$model, $request, $myself) {
            $model->name = $request->name;
            $model->email = $request->email;
            // not allow change own status to prevent lock out self
            if ($myself->id != $model->id) {
                $model->status = $request->status;
            }
            $model->save();

            // not allow change own roles to prevent lock out self
            if ($myself->id != $model->id) {
                $model->roles()->sync((empty($request->roles) ? [] : $request->roles));
            }
        });

        $resultMessage = sprintf(
            '%s user %s.',
            ($isCreate ? 'Created' : 'Updated'),
            $model->email
        );
        Auditlog::info('User', $resultMessage, $model->id);

        return redirect(route('manage-account.view', ['id' => $model->id]))->with('status', $resultMessage);
    }

    /**
     * Delete a record
     *
     * @param Request $request
     * @param integer $id
     * @return Response json encoded data
     */
    public function delete(Request $request, $id)
    {

        $result = [
            'alert-class' => 'error',
            'status' => 'Oops! Something goes wrong in ' . __FUNCTION__,
        ];

        $myself = $request->user();
        $model = User::findOrFail($id);

        if ($myself->id != $model->id) {
            try {
                DB::transaction(function () use ($model, &$result) {
                    $model->forceDelete();
    
                    $resultMessage = sprintf(
                        'Deleted user %s.',
                        $model->email
                    );
                    Auditlog::info('User', $resultMessage, $model->id);
    
                    $result['alert-class'] = 'success';
                    $result['status'] = $resultMessage;
                });
            } catch (QueryException $e) {
                switch ($e->getCode()) {
                    case 23000:
                        $result['status'] = 'Fail to delete the record which is referred by others.';
                        break;
                    default:
                        $result['status'] = $e->getMessage();
                        break;
                }
    
            }
        } else {
            $result['status'] = 'Not able to delete self.';
        }

        return response()->json($result);
    }
}
