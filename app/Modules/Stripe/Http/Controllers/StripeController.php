<?php

namespace App\Modules\Stripe\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Stripe\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * @property StripeService $stripeService
 */
class StripeController extends Controller
{
    public function __construct(StripeService $stripeService)
    {
        $this->middleware([
            'auth',
            'permission:' . User::PERMISSION_USER,
        ]);

        $this->stripeService = $stripeService;
    }

    /**
     * Success
     *
     * @param Request $request
     * @return Response content
     */
    public function success(Request $request)
    {
        return "success";
    }

    /**
     * Cancel 
     *
     * @param Request $request
     * @return Response content
     */
    public function cancel(Request $request)
    {
        return "cancel";
    }


    /**
     * Connect account 
     *
     * @param Request $request
     * @return Response redirect
     */
    public function connectAccount(Request $request)
    {
        $state = csrf_token();
        session('STRIPE_CONNECT_STATE', $state);

        $url = "https://connect.stripe.com/oauth/authorize";
        $query = http_build_query([
            "response_type" => "code",
            "client_id" => env("STRIPE_CLIENT_ID"),
            "scope" => "read_write",
            "state" => $state,
            "redirect_uri" => route("stripe.connect.callback"),
        ]);
        return redirect("{$url}?{$query}");
    }

    /**
     * Connect callback 
     *
     * @param Request $request
     * @return Response content
     */
    public function connectCallback(Request $request)
    {

        if (Session::token() != $request->state) {
            return "Invalid state";
        }

        if ($request->error) {
            return $request->error_description;
        }

        if (empty($request->code)) {
            return "Invalid access code";
        }

        $accessCode = $request->code;
        $connectAccount = $this->stripeService->createConnectAccount($accessCode);

        return "Connected account {$connectAccount->stripe_user_id}.";
    }

    /**
     * Payment Intent
     *
     * @param Request $request
     * @return Response content
     */
    public function paymentIntent(Request $request)
    {
        $intent = $this->stripeService->createPaymentIntent([
            'amount' => 999,
            'currency' => 'gbp',
        ]);

        return view('stripe::payment-intent', [
            'intent' => $intent
        ]);
    }
}
