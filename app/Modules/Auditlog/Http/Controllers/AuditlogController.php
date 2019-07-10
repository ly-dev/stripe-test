<?php
namespace App\Modules\Auditlog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auditlog\Models\Auditlog;
use Illuminate\Http\Request;

class AuditlogController extends Controller
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
     * @return view content
     */
    public function index(Request $request)
    {
        return view('auditlog::audit-log.index', []);
    }

    /**
     * List view - datatable ajax call
     *
     * @param Request $request
     * @return json encoded data
     */
    public function grid(Request $request)
    {
        $search = (object) [];

        if (isset($request->search['value'])) {
            $search->q = $request->search['value'];
        }

        $req = Auditlog::search($request->input('start'), $request->input('length'), $request->input('order'), $search);
        $data = $req->data
            ->map(function ($item) {
                $item->severity = Auditlog::$SEVERITY_LABELS[$item->severity];
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
}
