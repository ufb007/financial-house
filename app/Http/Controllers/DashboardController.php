<?php

namespace App\Http\Controllers;

use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

use function Pest\Laravel\json;

class DashboardController extends Controller
{
    /**
     * Constructor for the class.
     *
     * @param MerchantService $merchantService description
     */
    public function __construct(protected MerchantService $merchantService = new MerchantService())
    {
        $this->middleware('auth');
    }

    /**
     * A description of the entire PHP function.
     *
     * @return Response
     */
    public function reports(): Response 
    {
        $reports = $this->merchantService->getTransactionsReport('2010-01-01', '2024-03-01', 1);

        return Inertia::render('Reports', [
            'reports' => $reports['data']
        ]);
    }

    public function transactions(): Response 
    {

        //$transactions = $this->merchantService->getTransactionList();

        return Inertia::render('Transactions', ['apiToken' => session('api_token'), 'title' => 'This is the title']);
    }

    public function getTransactions(Request $request): JsonResponse 
    {
        ['fromDate' => $fromDate, 'toDate' => $toDate, 'page' => $page] = $request->all();

        $transactions = $this->merchantService->getTransactionList($fromDate, $toDate, $page);

        return response()->json(['success' => true, 'data' => $transactions['data']]);
    }

    public function clients(): Response 
    {
        $clients = $this->merchantService->getClient();

        return Inertia::render('Clients');
    }
}
