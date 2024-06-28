<?php

namespace Tests\Unit;

use App\Http\Repositories\MerchantRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);

it('sets the api_token in the session if it does not exist', function () {
    // Arrange: Mock the Http facade to simulate the login request and response
    Http::fake([
        'user/login' => Http::response([
            'token' => 'fake_token',
        ], 200)
    ]);

    // Act: Instantiate the repository and call setToken
    $merchantRepository = new MerchantRepository();
    $merchantRepository->setToken();

    // Assert: Check if api_token is set in the session
    expect(session('api_token'))->toBe('fake_token');
});

it('gets transaction reports', function() {
    $fromDate = '2022-01-01';
    $toDate = '2023-01-01';
    $merchantId = 1;

    Http::fake([
        'transactions/report' => Http::response([
            'status' => 'APPROVED',
            'response' => [
                [
                    'currency' => 'TRY',
                    'count' => 10,
                    'total' => 350961,
                ]
            ]
        ], 200)
    ]);

    // Act: Instantiate the repository and call getTransactionsReport
    $merchantRepository = new MerchantRepository();
    $response = $merchantRepository->getTransactionsReport($fromDate, $toDate, $merchantId);

    // Assert: Check if the transaction reports data is as expected
    expect($response)->toBeArray()
        ->and($response[0])->toMatchArray([
            'currency' => 'TRY',
            'count' => 10,
            'total' => 350961,
        ]);
});

it('gets transactions list', function () {
    // Arrange: Define the input parameters for the test
    $fromDate = '2010-01-01';
    $toDate = '2023-01-01';
    $page = 1;

    $data = [
        [
            "fx" => [
                "merchant" => [
                    "originalAmount" => 1000,
                    "originalCurrency" => "TRY",
                    "convertedAmount" => 1000,
                    "convertedCurrency" => "TRY"
                ]
            ],
            "updated_at" => "2020-11-23 23:26:54",
            "created_at" => "2020-11-23 23:26:53",
            "acquirer" => [
                "id" => 41,
                "name" => "Bank Transfer [BTP]",
                "code" => "BTP",
                "type" => "BANKTRANSFER"
            ],
            "transaction" => [
                "merchant" => [
                    "referenceNo" => "Test-Denem-Mongo-1",
                    "status" => "DECLINED",
                    "customData" => "",
                    "type" => "AUTH",
                    "operation" => "3D",
                    "created_at" => "2020-11-23 23:26:53",
                    "message" => "Decline",
                    "transactionId" => "1030245-1606174013-1307"
                ]
            ],
            "customerInfo" => [
                "billingFirstName" => "CEM",
                "billingLastName" => "VAROL",
                "email" => "cem@freelancer.run"
            ],
            "merchant" => [
                "id" => 1307,
                "name" => "G-Merchant"
            ]
        ]
    ];

    // Prepare a fake Http response for the transaction list endpoint
    Http::fake([
        "transaction/list?page=$page" => Http::response([
            'data' => $data
        ], 200)
    ]);

    // Act: Instantiate the repository and call getTransactionList
    $merchantRepository = new MerchantRepository();
    $response = $merchantRepository->getTransactionList($fromDate, $toDate, $page);

    $json = json_encode($response->data);

    // Assert: Verify the response is as expected
    expect($response->data)->toBeArray()
        ->and(json_decode($json, true))->toMatchArray($data);
});
