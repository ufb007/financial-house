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
    $fromDate = '2010-01-01';
    $toDate = '2024-01-31';
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
    expect($response)->toBeArray();
});

it('gets transactions list', function () {
    // Arrange: Define the input parameters for the test
    $fromDate = '2022-01-01';
    $toDate = '2023-01-01';
    $page = 1;

    // Prepare a fake Http response for the transaction list endpoint
    Http::fake([
        'transactions/list' => Http::response([
            'status' => 'APPROVED',
            'data' => [
                [
                    'transactionId' => 'tx123',
                    'amount' => 100,
                    'currency' => 'USD',
                    'status' => 'completed',
                ],
                [
                    'transactionId' => 'tx124',
                    'amount' => 200,
                    'currency' => 'EUR',
                    'status' => 'pending',
                ]
            ]
        ], 200)
    ]);

    // Act: Instantiate the repository and call getTransactionList
    $merchantRepository = new MerchantRepository();
    $response = $merchantRepository->getTransactionList($fromDate, $toDate, $page);

    // Assert: Verify the response is as expected
    expect($response)->toBeArray()
        ->and($response[0])->toMatchArray([
            'transactionId' => 'tx123',
            'amount' => 100,
            'currency' => 'USD',
            'status' => 'completed',
        ]);
});
