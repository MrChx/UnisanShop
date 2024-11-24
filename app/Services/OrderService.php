<?php 

namespace App\Services;

use App\Models\ProductTransaction;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use App\Repositories\Contracts\FoodRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $categoryRepository;
    protected $promoCodeRepository;
    protected $orderRepository;
    protected $foodRepository;

    public function __construct(
        PromoCodeRepositoryInterface $promoCodeRepository,
        CategoryRepositoryInterface $categoryRepository,
        OrderRepositoryInterface $orderRepository,
        FoodRepositoryInterface $foodRepository
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
        $this->foodRepository = $foodRepository;
    }

    public function beginOrder(array $data)
    {
        $orderData = [
            'food_id' => $data['food_id'] ?? null, // Validasi default null
        ];
        $this->orderRepository->saveToSession($orderData);
    }

    public function getMyOrderDetails(array $validated)
    {
        return $this->orderRepository->findByTrxAndNim($validated['booking_trx_id'], $validated['nim']);
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();
        
        if (empty($orderData['food_id'])) {
            return ['error' => 'Order data not found'];
        }

        $food = $this->foodRepository->find($orderData['food_id']);

        if (!$food) {
            return ['error' => 'Food not found'];
        }

        $quantity = $orderData['quantity'] ?? 1;
        $subTotalAmount = $food->price * $quantity;

        $taxRate = 0; 
        $totalTax = $subTotalAmount * $taxRate;

        $grandTotalAmount = $subTotalAmount + $totalTax;

        $orderData['sub_total_amount'] = $subTotalAmount;
        $orderData['total_tax'] = $totalTax;
        $orderData['grand_total_amount'] = $grandTotalAmount;

        return [
            'orderData' => $orderData,
            'food' => $food // Perbaikan: Pastikan food selalu direturn
        ];
    }


    public function applyPromoCode(string $code, int $subTotalAmount)
    {
        $promo = $this->promoCodeRepository->findByCode($code);

        if ($promo) {
            $discount = $promo->discount_amount;
            $grandTotalAmount = $subTotalAmount - $discount;
            $promoCodeId = $promo->id;
            return [
                'discount' => $discount,
                'grandTotalAmount' => $grandTotalAmount,
                'promoCodeId' => $promoCodeId,
            ];
        }
        return ['error' => 'Kode promo tidak tersedia'];
    }

    public function saveBookingTransaction(array $data)
    {
        $this->orderRepository->saveToSession($data);
    }

    public function updateCostumerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    public function paymentConfirm(array $validated)
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();

        // Log isi data order dari sesi
        Log::info('Order data from session: ', $orderData);

        if (empty($orderData)) {
            Log::error('Order data is empty.');
            session()->flash('error', 'Order data is missing.');
            return null;
        }

        $productTransactionId = null;

        try {
            DB::transaction(function () use ($validated, &$productTransactionId, $orderData) {
                // Validasi dan upload proof
                if (isset($validated['proof']) && $validated['proof']->isValid()) {
                    $proofPath = $validated['proof']->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                } else {
                    Log::warning('Proof file is invalid or missing.');
                    throw new \Exception('Proof file is invalid or missing.');
                }

                // Validasi data sebelum disimpan
                $validated = array_merge($validated, [
                    'name' => $orderData['name'] ?? null,
                    'nim' => $orderData['nim'] ?? null,
                    'email' => $orderData['email'] ?? null,
                    'faculty' => $orderData['faculty'] ?? null,
                    'major' => $orderData['major'] ?? null,
                    'quantity' => $orderData['quantity'] ?? 1,
                    'sub_total_amount' => $orderData['sub_total_amount'] ?? 0,
                    'grand_total_amount' => $orderData['grand_total_amount'] ?? 0,
                    'discount_amount' => $orderData['discount_amount'] ?? 0,
                    'promo_code_id' => $orderData['promo_code_id'] ?? null,
                    'food_id' => $orderData['food_id'] ?? null,
                    'is_paid' => true,
                    'booking_trx_id' => ProductTransaction::generateUniqueTrxId(),
                ]);

                Log::info('Validated data for transaction: ', $validated);

                // Simpan transaksi ke database
                $newTransaction = $this->orderRepository->createTransaction($validated);
                $productTransactionId = $newTransaction->id;

            $this->orderRepository->clearSession();

                Log::info('Transaction created with ID: ' . $productTransactionId);
            });
        } catch (\Exception $e) {
            Log::error('Error in payment confirmation: ' . $e->getMessage());
            session()->flash('error', 'Payment confirmation failed: ' . $e->getMessage());
            return null;
        }

        return $productTransactionId;
    }
}
