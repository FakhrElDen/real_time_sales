<?php

namespace App\Http\Controllers;

use App\Events\OrderCountUpdated;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Services\ChatgptService;
use App\Http\Services\GeminiService;
use App\Http\Services\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected GeminiService $geminiService,
        protected ChatgptService $chatgptService,
    ) {
        //
    }

    public function analytics()
    {
        $analytics = $this->orderService->analytics();

        return response()->json([
            'status_code'       => 200,
            'status'            => true,
            'message'           => 'success',
            'data'              => $analytics,
        ]);
    }

    public function create(CreateOrderRequest $request)
    {
        DB::beginTransaction();

        $order = $this->orderService->store($request->validated());

        $analytics = $this->orderService->analytics();

        broadcast(new OrderCountUpdated($analytics));

        DB::commit();

        return response()->json([
            'status_code'       => 200,
            'status'            => true,
            'message'           => 'success',
            'data'              => new OrderResource($order),
        ]);
    }

    public function recommendations()
    {
        $analytics = $this->orderService->analytics();

        $result = $this->geminiService->productPromotionSuggestions(json_encode($analytics));

        return response()->json([
            'status_code'       => 200,
            'status'            => true,
            'message'           => 'success',
            'data'              => $result,
        ]);
    }
}
