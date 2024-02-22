<?php

namespace App\Http\Controllers;

use App\Services\MerchantService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(protected MerchantService $merchantService = new MerchantService())
    {
        $this->middleware('auth');
    }

    public function reports(): Response 
    {
        $reports = $this->merchantService->getTransactionsReport('2010-01-01', '2024-03-01', 1);

        return Inertia::render('Reports', [
            'reports' => $reports['data']
        ]);
    }

    public function transactions(): Response 
    {
        $transactions = $this->merchantService->getTransactionList();

        return Inertia::render('Transactions');
    }

    public function clients(): Response 
    {
        $clients = $this->merchantService->getClient();

        return Inertia::render('Clients');
    }
}
