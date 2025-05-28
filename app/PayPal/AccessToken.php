<?php

namespace App\Paypal;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response as HttpResponse;

/**
 * Convert string to URL
 * @param string $url String to be converted to url
 * @return string Encoded URL
 */
function encodeURL(string $url): string
{
    return str_replace('+', '%20', urlencode(($url)));
}

class AccessToken {
    /**
     * Return response according to Http Response
     * @param HttpResponse $response
     * @return array{'status': boolean, 'response': mixed}
     */
    private static function returnData(HttpResponse $response): array
    {
        if ($response->successful()) {
            return ['status' => true, 'response' => $response->json()];
        }
        if ($response->failed()) {
            return ['status' => false, 'response' => $response->json()];
        }
        return ['status' => false, 'response' => 'Something went wrong'];
    }

    /**
     * Generate Access Token for PayPal
     * @return array{'status': boolean, 'response': mixed}
     */
    public static function generate(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . encodeURL(config('paypal.paypal_client_id').':'.config('paypal.paypal_client_secret')),
        ])->post(config('app.paypal_url').'oauth2/token', [
            'grant_type' => 'client_credentials'
        ]);

        return self::returnData($response);
    }
}
