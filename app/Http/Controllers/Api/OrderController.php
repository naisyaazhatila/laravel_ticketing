<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\order_item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request-> validate([
                'total_price' => 'required',
                'total_item' => 'required|integer',
                'payment_amount' => 'required',
                'cachier_id' => 'required|exists:users,id',
                'cashier_name' => 'required',
                'payment_method' => 'required',
                'transaction_time' => 'required',
            ]);

            $order = new Order();
            $order->total_price = $request->total_price;
            $order->total_item = $request->total_item;
            $order->payment_amount = $request->payment_amount;
            $order->cachier_id = $request->cachier_id;
            $order->cashier_name = $request->cashier_name;
            $order->payment_method = $request->payment_method;
            $order->transaction_time = $request->transaction_time;
            $order->save();


        foreach ($request->order_items as $item) {
            $orderItem = new order_item();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->total_price = $item['total_price'] * $item['quantity'];
            $orderItem->save();
        };

        return response()->json([
            'status' => 'success',
            'data' => $order,
        ], 201);
}


}