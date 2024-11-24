<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use App\Models\ProductTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderRepository implements OrderRepositoryInterface
{
    public function createTransaction(array $data)
    {
        Log::info('Creating new ProductTransaction with data: ', $data);

        return ProductTransaction::create($data);
    }
    
    public function findByTrxAndNim($bookingTrxId, $nim)
    {
        return ProductTransaction::where('booking_trx_id', $bookingTrxId)
                                    ->where('nim', $nim)
                                     ->first();    
    }

    public function saveToSession(array $data)
    {
        $existingData = session('orderData', []);
        $mergedData = array_merge($existingData, $data);
        Session::put('orderData', $mergedData);

        Log::info('Data saved to session: ', $mergedData);
    }

    public function getOrderDataFromSession()
    {
        $orderData = session('orderData', []);
        Log::info('Retrieved order data from session: ', $orderData);
        return $orderData;
    }

    public function updateSessionData(array $data)
    {
        $orderData = session('orderData', []);
        $orderData = array_merge($orderData, $data);
        session(['orderData' => $orderData]);

        Log::info('Session data updated: ', $orderData);
    }

    public function clearSession()
    {
        Session::forget('orderData');
    }
}