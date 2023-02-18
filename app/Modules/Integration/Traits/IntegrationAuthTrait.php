<?php

namespace App\Modules\Integration\Traits;

use Illuminate\Support\Facades\Http;

trait IntegrationAuthTrait
{
    public function getAccessToken($url, $key, $secret)
    {
        $response = Http::asForm()->post($url, [
            'grant_type'    => 'client_credentials',
            'client_id'     => $key,
            'client_secret' => $secret,
            'scope'         => '*',
        ]);

        return $response->json()['access_token'];
    }
}
