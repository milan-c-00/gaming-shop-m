<?php

namespace App\Http\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use App\Models\Cart;

class OrderService {

    public function index() {

        return Order::query()->get();

    }

    public function store($request) {

        $cart = Cart::query()
            ->where('user_id', new ObjectId($request->user_id))
            ->where('status', 'active')
            ->first();

        if(!$cart || !$cart->items)
            return response()->json([
                "success" => false,
                "message" => "Cart is empty!"
            ]);

        $order = new Order();
        $order->user_id = $request->user()->id;
        $order->items = $cart->items;
        $order->total_price = $cart->total_price;
        $order->status = 'pending';
        $order->save();

        $cart->status = 'checked_out';
        $cart->save();

        return response()->json([
            "success" => true,
            "message" => "Order successful!",
            "order" => $order
        ]);

    }

    public function show($order) {

        return Order::query()
            ->where('_id', new ObjectId($order))
            ->first();

    }

    public function update() {
        return null;
    }

    public function destroy($order) {

        return Order::query()
            ->where('_id', new ObjectId($order))
            ->delete();

    }

    public function myOrders(Request $request) {

        return Order::query()
            ->where('user_id', new ObjectId($request->user_id))
            ->get();

    }

}
