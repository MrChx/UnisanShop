<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckBookingRequest;
use App\Http\Requests\StoreCostumerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\food;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function saveOrder(StoreOrderRequest $request, food $food)
    {
        $validated = $request->validated();
        $validated['food_id'] = $food->id;
        $this->orderService->beginOrder($validated);

        return redirect()->route('front.booking', $food->slug);
    }

    public function booking(food $food)
    {
        $data = $this->orderService->getOrderDetails();
        // dd($data); // Pastikan food diisi dengan benar
        return view('order.order', $data);
    }

    public function costumerData()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.costumer_data', $data);
    }

    public function saveCostumerData(StoreCostumerDataRequest $request)
    {
        $validated = $request->validated();
        $this->orderService->updateCostumerData($validated);

        return redirect()->route('front.payment');
    }

    public function payment()
    {
        $data = $this->orderService->getOrderDetails();
        // dd($data);
        return view('order.payment', $data);
    }

    public function paymentConfirm(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        $productTransactionId = $this->orderService->paymentConfirm($validated);

        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }

        return redirect()->route('front.payment')->withErrors(['error' => 'payment failed. please try again']);
    }

    public function orderFinished(ProductTransaction $productTransaction)
    {
        return view('order.order_finished', compact('productTransaction'));
    }

    public function checkBooking() {
        return view('order.my_order');
    }

    public function checkBookingDetails(StoreCheckBookingRequest $request)
    {
        $validated = $request->validated();

        $orderDetails = $this->orderService->getMyOrderDetails($validated);
        if ($orderDetails) {
            return view('order.my_order_details', compact('orderDetails'));
        }

        return redirect()->route('front.check_booking')->withErrors(['error' => 'Transaction not found']);
    }
}