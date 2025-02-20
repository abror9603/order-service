<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderService $order)
    {
        $this->order = $order;
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $response = $this->order->getAll();

        return $response 
        ? response()->json($response, 200)
        : response()->json(["message" => "Not found orders"], 404);
    }

   
    public function store(StoreOrderRequest $request)
    {
        $userId = auth()->id();
        $validated = $request->validated();
        $response = $this->order->createData($validated, $userId);

        return $response 
        ? response()->json(["message" => "Create successfully order!"], 200)
        : response()->json(["message" => "Not found orders"], 500);
    }

   
    public function show(int $id)
    {
        $response = $this->order->getOne($id);

        return $response 
        ? response()->json($response , 200)
        : response()->json(["message" => "Not found order"], 404);
    }

   
    public function update(UpdateOrderRequest $request, int $id)
    {
         $validatedData = $request->validated();
        $response = $this->order->updateData($validatedData, $id);

        return $response 
        ? response()->json(["message" => "Update successfully order!"], 200)
        : response()->json(["message" => "Can not update order"], 500);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|string'
        ]);

        return $this->order->updateSerStatus($request->all());
    }

   
    public function destroy(int $id)
    {
        $response = $this->order->deleteData($id);

        return $response 
        ? response()->json(["message" => "Delete successfully order!"], 200)
        : response()->json(["message" => "Can not delete order"], 500);
    }
}
