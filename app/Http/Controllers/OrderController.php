<?php

namespace App\Http\Controllers;

use App\Events\OrderCountUpdated;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Repositories\OrderRepository;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(protected OrderRepository $orderRepository)
    {

    }

    public function index()
    {

    }

    public function create(CreateOrderRequest $request)
    {
        DB::beginTransaction();
        
        $order = $this->orderRepository->store($request->validated());
        $count = $this->orderRepository->count();
        
        broadcast(new OrderCountUpdated($count));
        
        return response()->json([
            'status_code'       => 200,
            'status'            => true,
            'message'           => 'success',
            'data'              => new OrderResource($order),
        ]);

        DB::commit();
    }
}
