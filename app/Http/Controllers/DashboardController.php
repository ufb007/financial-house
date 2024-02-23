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
        return Inertia::render('Reports');
    }

    public function getReports(Request $request): JsonResponse
    {
        ['fromDate' => $fromDate, 'toDate' => $toDate, 'page' => $page] = $request->all();

        $reports = $this->merchantService->getTransactionsReport($fromDate, $toDate, $page);

        return response()->json(['success' => true, 'data' => $reports['data']]);
    }

    public function transactions(): Response 
    {
        return Inertia::render('Transactions');
    }

    public function getTransactions(Request $request): JsonResponse 
    {
        ['fromDate' => $fromDate, 'toDate' => $toDate, 'page' => $page] = $request->all();

        $transactions = $this->merchantService->getTransactionList($fromDate, $toDate, $page);

        return response()->json(['success' => true, 'data' => $transactions['data']]);
    }

    public function getTransaction(): JsonResponse
    {
        ['transactionId' => $transactionId] = request()->all();

        $transaction = $this->merchantService->getTransaction($transactionId);

        return response()->json(['success' => true, 'data' => $transaction['data']]);
    }
}
