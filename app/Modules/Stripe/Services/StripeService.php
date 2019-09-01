<?php

namespace App\Stripe\Services;

use App\Stripe\Models\StripeConnectAccount;
use Illuminate\Support\Collection;
use GuzzleHttp\Client as HttpClient;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    private $secretKey;
    private $successUrl;
    private $cancelUrl;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->secretKey = env('STRIPE_SECRET_KEY');
        Stripe::setApiKey($this->secretKey);

        $this->successUrl = route('stripe.success');
        $this->cancelUrl = route('stripe.cancel');
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
                "grant_type" => "authorization_code"
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

    public function issueTokenForPasswordGrantClient(PassportClient $passportClient, $clientCode, $clientSecretKey, $scopes = [])
    {
        $result = false;

        $httpClient = new HttpClient();
        $url = $this->getOauthUrl('token');

        $response = $httpClient->post($url, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $passportClient->id,
                'client_secret' => $passportClient->secret,
                'username' => $clientCode,
                'password' => $clientSecretKey,
                'scope' => implode(' ', $scopes),
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
