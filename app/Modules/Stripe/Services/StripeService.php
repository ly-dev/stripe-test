<?php

namespace App\Stripe\Services;

use App\Stripe\Models\StripeConnectAccount;
use GuzzleHttp\Client as HttpClient;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    private $secretKey;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->secretKey = config('stripe.secret_key');
        Stripe::setApiKey($this->secretKey);
    }

    public function createConnectAccount($accessCode)
    {
        $result = null;

        $url = "https://connect.stripe.com/oauth/token";
        $httpClient = new HttpClient();

        $response = $httpClient->post($url, [
            'form_params' => [
                "client_secret" => $this->secretKey,
                "code" => $accessCode,
                "grant_type" => "authorization_code",
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        $result = StripeConnectAccount::create($data);

        return $result;
    }

    public function createPaymentIntent($data)
    {
        $result = null;

        $result = PaymentIntent::create($data);

        return $result;
    }

}
