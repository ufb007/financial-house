<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Http;

class MerchantRepository {
    public function __construct()
    {
        $this->setToken();
    }

    /**
     * Set the token if it doesn't already exist in the session.
     *
     * @throws \Exception description of exception
     */
    public function setToken(): void {
        try {
            if (!session('api_token')) {
                $response = Http::merchant()->post('merchant/user/login', [
                    'email' => env('MERCHANT_EMAIL'),
                    'password' => env('MERCHANT_PASSWORD'),
                ]);

                $body = json_decode($response->getBody()->getContents());

                session()->put('api_token', $body->token);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Get transactions report from the specified dates.
     *
     * @param String $fromDate description
     * @param String $toDate description
     * @throws \Exception description of exception
     * @return array
     */
    public function getTransactionsReport(String $fromDate, String $toDate, int $merchantId): array | String {
        try {
            $response = Http::withHeader('Authorization', session('api_token'))->post(env('MERCHANT_API_URI') . 'transactions/report', [
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'merchant' => $merchantId
            ]);

            $body = json_decode($response->getBody()->getContents());

            if ($body->status === 'APPROVED') {
                return $body->response;
            }

            throw new \Exception($body->message);
        } catch (\Exception $e) {
            session()->forget('api_token');

            return $e->getMessage();
        }
    }

    public function getTransactionList() 
    {

    }
}