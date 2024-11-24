<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function createTransaction(array $data);
    public function findByTrxAndNim($bookingTrxId, $nim);
    public function saveToSession(array $data);
    public function updateSessionData(array $data);
    public function getOrderDataFromSession();
    public function clearSession();
}