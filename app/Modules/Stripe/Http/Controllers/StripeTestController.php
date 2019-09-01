<?php

namespace App\Modules\Stripe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StripeTestController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'permission:' . User::PERMISSION_USER,
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
        return view('stripe::index', []);
    }

    /**
     * Stripe elements
     *
     * @param Request $request
     * @return Response content
     */
    public function stripeElements(Request $request)
    {
        return view('stripe::elements', []);
    }


    /**
     * Stripe 3D Secure 2
     *
     * @param Request $request
     * @return Response content
     */
    public function stripe3DSecure2(Request $request)
    {
        return view('stripe::3d-secure-2', []);
    } 
}
