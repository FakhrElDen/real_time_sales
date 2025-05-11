<?php

namespace App\Http\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function __construct(protected Order $model)
    {
        //
    }

    public function store($data)
    {   
        return $this->model->create($data);
    }

    public function count()
    {
        return DB::table('orders')->count();
    }
    
}