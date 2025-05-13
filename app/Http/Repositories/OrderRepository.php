<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function __construct()
    {
        //
    }

    public function totalRevenue()
    {
        return DB::table('orders')
            ->selectRaw('SUM(price * quantity) as total_revenue')
            ->value('total_revenue');
    }

    public function topProducts()
    {
        return DB::table('orders')
            ->select('product_id', 'price', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
    }

    public function revenueLastMinute()
    {
        return DB::table('orders')
            ->where('created_at', '>=', now()->subMinute())
            ->selectRaw('SUM(price * quantity) as total_revenue')
            ->value('total_revenue');
    }

    public function orderCountLastMinute()
    {
        return DB::table('orders')
            ->where('created_at', '>=', now()->subMinute())
            ->count();
    }

    public function count()
    {
        return DB::table('orders')->count();
    }

    public function store($data)
    {
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $insertedId = DB::table('orders')->insertGetId($data);

        return DB::table('orders')->where('id', $insertedId)->first();
    }
}
