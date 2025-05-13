<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;

class OrderService
{
    public function __construct(protected OrderRepository $orderRepository,)
    {
        //
    }

    public function analytics()
    {
        $totalRevenue = $this->orderRepository->totalRevenue();
        $topProducts = $this->orderRepository->topProducts();
        $revenueLastMinute = $this->orderRepository->revenueLastMinute();
        $orderCountLastMinute = $this->orderRepository->orderCountLastMinute();
        $ordersCount = $this->orderRepository->count(); 

        return [
            'total_revenue' => $totalRevenue ?? 0,
            'top_products' => $topProducts,
            'revenue_last_minute' => $revenueLastMinute ?? 0,
            'order_count_last_minute' => $orderCountLastMinute,
            'orders_count' => $ordersCount,
        ];
    }
    
    public function store($data)
    {
        return $this->orderRepository->store($data);
    }
}
