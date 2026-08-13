<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PayTabsService
{
    protected string $profileId;

    protected string $serverKey;

    protected string $region;

    protected string $currency;

    protected string $baseUrl;


    public function __construct()
    {
        $this->profileId = config('services.paytabs.profile_id');

        $this->serverKey = config('services.paytabs.server_key');

        $this->region = config(
            'services.paytabs.region',
            'EGY'
        );

        $this->currency = config(
            'services.paytabs.currency',
            'EGP'
        );

        $this->baseUrl = $this->getBaseUrl();
    }


    protected function getBaseUrl(): string
    {
        return match ($this->region) {

            'ARE' => 'https://secure.paytabs.com',

            'SAU' => 'https://secure.paytabs.sa',

            'OMN' => 'https://secure.paytabs.com',

            'JOR' => 'https://secure.jordan.paytabs.com',

            'EGY' => 'https://secure-egypt.paytabs.com',

            default => 'https://secure.paytabs.com',
        };
    }


    public function createPayment(
        string $cartId,
        float $amount,
        array $customer,
        string $returnUrl,
        string $callbackUrl
    ): array {

        $payload = [

            'profile_id' => (int) $this->profileId,

            'tran_type' => 'sale',

            'tran_class' => 'ecom',

            'cart_id' => $cartId,

            'cart_description' => 'Order ' . $cartId,

            'cart_currency' => $this->currency,

            'cart_amount' => $amount,

            'return' => $returnUrl,

            'callback' => $callbackUrl,

            'customer_details' => [

                'name' => $customer['name'],

                'email' => $customer['email'],

                'phone' => $customer['phone'],

                'street1' => $customer['address'] ?? '',

                'city' => $customer['city'] ?? '',

                'state' => $customer['state'] ?? '',

                'country' => $customer['country'] ?? '',

                'zip' => $customer['zip'] ?? '',
            ],
            'payment_methods' => ['all'],
        ];


        $response = Http::withHeaders([

            'Authorization' => $this->serverKey,

            'Content-Type' => 'application/json',

        ])->post(

            $this->baseUrl . '/payment/request',

            $payload

        );


        if ($response->failed()) {

            throw new RuntimeException(
                'PayTabs API request failed: ' .
                $response->body()
            );
        }


        $data = $response->json();


        if (empty($data['redirect_url'])) {

            throw new RuntimeException(
                'PayTabs did not return redirect_url: ' .
                $response->body()
            );
        }


        return $data;
    }


    public function queryTransaction(
        string $tranRef
    ): array {

        $response = Http::withHeaders([

            'Authorization' => $this->serverKey,

            'Content-Type' => 'application/json',

        ])->post(

            $this->baseUrl . '/payment/query',

            [

                'profile_id' => (int) $this->profileId,

                'tran_ref' => $tranRef,

            ]

        );


        if ($response->failed()) {

            throw new RuntimeException(
                'PayTabs query failed: ' .
                $response->body()
            );
        }


        return $response->json();
    }
}
