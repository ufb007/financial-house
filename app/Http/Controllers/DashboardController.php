<?php

namespace App\Http\Controllers;

use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

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

    /**
     * A description of the entire PHP function.
     *
     * @return Response
     */
    public function transactions(): Response 
    {
        return Inertia::render('Transactions');
    }

    /**
     * Get reports from specified date range and page number.
     *
     * @param string $fromDate description
     * @param string $toDate description
     * @param integer $page description
     * @throws Some_Exception_Class description of exception
     * @return JsonResponse
     */
    public function getReports(String $fromDate, String $toDate, int $page): JsonResponse
    {
        $validator = validator::make(compact('fromDate', 'toDate', 'page'), [
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
            'page' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'data' => []], 422);
        }

        $reports = $this->merchantService->getTransactionsReport($fromDate, $toDate, $page);

        return response()->json(['success' => true, 'data' => $reports['data']]);
    }

    /**
     * Get transactions from the specified date range and page number.
     *
     * @param String $fromDate The start date for the transaction search
     * @param String $toDate The end date for the transaction search
     * @param int $page The page number for paginated results
     * @return JsonResponse
     */
    public function getTransactions(String $fromDate, String $toDate, int $page): JsonResponse 
    {
        $validator = validator::make(compact('fromDate', 'toDate', 'page'), [
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
            'page' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'data' => []], 422);
        }

        $transactions = $this->merchantService->getTransactionList($fromDate, $toDate, $page);

        return response()->json(['success' => true, 'data' => $transactions['data']]);
    }

    public function getTransaction(String $transactionId): JsonResponse
    {
        $validator = Validator::make(compact('transactionId'), [
            'transactionId' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'data' => []], 422);
        }

        $transaction = $this->merchantService->getTransaction($transactionId);

        return response()->json(['success' => true, 'data' => $transaction['data']]);
    }
}
