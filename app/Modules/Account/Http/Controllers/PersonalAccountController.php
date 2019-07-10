<?php

namespace App\Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'permission:' . User::PERMISSION_USER,
        ]);
    }

    /**
     * Change password form
     *
     * @param Request $request
     * @return view content
     */
    public function changePasswordForm(Request $request)
    {
        return view('account::personal-account.change-password', []);
    }

    /**
     * Change password process
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function changePasswordProcess(Request $request)
    {
        $model = $request->user();

        $this->validate($request, [
            'old_password' => ['required',
                'max:190',
                'current_password:' . $model->id,
            ],
            'new_password' => ['required',
                'max:190',
                'confirmed',
                'password_policy',
            ],
        ]);

        $model->password = bcrypt($request->new_password);
        $model->save();

        return redirect(route('account.change-password'))->with('status', 'New password saved.');
    }
}
