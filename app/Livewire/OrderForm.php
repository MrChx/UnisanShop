<?php

namespace App\Livewire;

use App\Models\Food;
use App\Services\OrderService;
use Livewire\Component;

class OrderForm extends Component
{
    public Food $food;
    public $orderData;
    public $subTotalAmount;
    public $promoCode = null;
    public $promoCodeId = null;
    public $quantity = 0; 
    public $discount = 0;
    public $grandTotalAmount;
    public $totalDiscountAmount = 0;
    public $name;
    public $email;

    protected $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function updateQuantity()
    {
        $this->validateOnly('quantity', [
            'quantity' => 'required|integer|min:0|max:' . $this->food->stock, // Ubah min:1 ke min:0
        ], [
            'quantity.max' => 'stok tidak tersedia',
        ]);
        $this->calculateTotal();
    }

    protected function calculateTotal(): void
    {
        if ($this->quantity <= 0) {
            $this->subTotalAmount = 0;
            $this->grandTotalAmount = 0;
            return;
        }
        
        $this->subTotalAmount = $this->food->price * $this->quantity;
        $this->grandTotalAmount = $this->subTotalAmount - $this->discount;
    }

    public function mount(Food $food, $orderData)
    {
        $this->food = $food;
        $this->orderData = $orderData;
        $this->quantity = 0; // Set nilai awal ke 0
        $this->subTotalAmount = 0; // Set nilai awal ke 0
        $this->grandTotalAmount = 0; // Set nilai awal ke 0
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->food->stock) {
            $this->quantity++;
            $this->calculateTotal();
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 0) { // Ubah dari 1 ke 0
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function updatedQuantity()
    {
        // Validasi ketika quantity diupdate secara langsung
        if ($this->quantity < 0) {
            $this->quantity = 0;
        } elseif ($this->quantity > $this->food->stock) {
            $this->quantity = $this->food->stock;
        }
        $this->calculateTotal();
    }

    public function updatedPromoCode()
    {
        $this->applyPromoCode();
    }

    public function applyPromoCode()
    {
        if (!$this->promoCode || $this->quantity <= 0) {
            $this->resetDiscount();
            return;
        }

        $result = $this->orderService->applyPromoCode($this->promoCode, $this->subTotalAmount);

        if (isset($result['error'])) {
            session()->flash('error', $result['error']);
            $this->resetDiscount();
        } else {
            session()->flash('message', 'kode promo tersedia');
            $this->discount = $result['discount'];
            $this->promoCodeId = $result['promoCodeId'];
            $this->totalDiscountAmount = $result['discount'];
            $this->calculateTotal();
        }
    }

    public function resetDiscount()
    {
        $this->discount = 0;
        $this->promoCodeId = null;
        $this->totalDiscountAmount = 0;
        $this->calculateTotal();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:0|max:' . $this->food->stock, // Ubah min:1 ke min:0
        ];
    }

    protected function gatherBookingData(array $validatedData): array
    {
        return [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'grand_total_amount' => $this->grandTotalAmount,
            'sub_total_amount' => $this->subTotalAmount,
            'total_discount_amount' => $this->totalDiscountAmount,
            'discount' => $this->discount,
            'promo_code' => $this->promoCode,
            'promo_code_id' => $this->promoCodeId,
            'quantity' => $this->quantity,
        ];
    }

    public function submit()
    {
        // Tambah validasi quantity harus lebih dari 0 sebelum submit
        if ($this->quantity <= 0) {
            session()->flash('error', 'Quantity harus lebih dari 0');
            return;
        }

        $validatedData = $this->validate();
        $bookingData = $this->gatherBookingData($validatedData);
        
        $this->orderService->updateCostumerData($bookingData);
        
        return redirect()->route('front.costumer_data');
    }

    public function render()
    {
        return view('livewire.order-form', [
            'food' => $this->food,
            'orderData' => $this->orderData
        ]);
    }
}