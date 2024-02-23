<?php

namespace App\Services;

use App\Http\Repositories\MerchantRepository;

class MerchantService 
{
    /**
     * Constructor for the class.
     *
     * @param MerchantRepository $merchantRepository description
     */
    public function __construct(
        protected MerchantRepository $merchantRepository = new MerchantRepository()
    )
    {
        
    }

    public function getTransactionsReport(String $fromDate, String $toDate, int $merchantId): array
    {
        try {
            $reports = $this->merchantRepository->getTransactionsReport($fromDate, $toDate, $merchantId);

            return ['success' => true, 'data' => $reports];
        } catch (\Exception $e) {
            if ($e->getMessage() === "Token expired") {
                $this->merchantRepository->setToken();

                return ['success' => false, 'data' => [], 'message' => $e->getMessage()];
            }
        }
    }

    public function getTransactionList($fromDate, $toDate, $page = 1): array 
    {
        try {
            $response = $this->merchantRepository->getTransactionList($fromDate, $toDate, $page);

            return ['success' => true, 'data' => $response];
        } catch (\Exception $e) {
            if ($e->getMessage() === "Token expired") {
                $this->merchantRepository->setToken();

                return ['success' => false, 'data' => [], 'message' => $e->getMessage()];
            }
        }
    }

    public function getTransaction(String $transcationId): array
    {
        try {
            $response = $this->merchantRepository->getTransaction($transcationId);

            return ['success' => true, 'data' => $response];
        } catch (\Exception $e) {
            if ($e->getMessage() === "Token expired") {
                $this->merchantRepository->setToken();

                return ['success' => false, 'data' => [], 'message' => $e->getMessage()];
            }
        }
    }
}