<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class CartService {

    // Get a single active user cart
    public function show($cart) {

        return Cart::query()->find(new ObjectId($cart))->first();

    }

    // Add initial items of a kind to cart and create new cart if doesn't exist
    public function add(Request $request) {

        $product = Product::query()->where("_id", new ObjectId($request->product_id))->first();

        if (!$product || $product->stock < $request->quantity) {
            return [
                "success" => false,
                "message" => "Insufficient stock!"
            ];
        }

        $cart = Cart::query()->firstOrCreate([
            'user_id' => $request->user()->id,
            'status' => 'active'
        ]);

//        if(!$cart->items)
//            $cart->total_price = 0;

        $cart->push(
            'items',
            [
                'product_id' => $product->_id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]
        );

        $cart->total_price += $product->price * $request->quantity;
        $cart->save();

        $product->stock -= $request->quantity;
        $product->save();

        return [
            "success" => true,
            "cart" => json_decode(json_encode($cart), true),
            "message" => "OK!"
        ];
    }

    // Update cart items quantity
    public function update($cart, Request $request) {

        $cart = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->where('items.product_id', $request->product_id)
            ->first();

        if(!$cart){
            return [
                "success" => false,
                "message" => "Cart not available!"
            ];
        }

        $product = Product::query()
            ->where('_id', new ObjectId($request->product_id))
            ->first();

        if(!$product){
            return [
                "success" => false,
                "message" => "Product not found!"
            ];
        }

        foreach ($cart->items as $item) {
            if ((string)$item['product_id'] === (string)$request->product_id) {
                $currentQuantity = $item['quantity'];
                break;
            }
        }

        $quantityDifference = $request->quantity - $currentQuantity;

        if ($quantityDifference > 0 && $product->stock < $quantityDifference) {
            return [
                "success" => false,
                "message" => "Not enough stock available!"
            ];
        }

        $product->stock -= $quantityDifference;
        $product->save();

        Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->where('items.product_id', $request->product_id)
            ->update([
                'items.$.quantity' => $request->quantity,
            ]);

        $newTotal = 0;
        $cart = Cart::query()->where('_id', $cart->_id)->first(); // Refresh cart
        foreach ($cart->items as $item) {
            $newTotal += $item['quantity'] * $item['price'];
        }
        $cart->total_price = $newTotal;
        $cart->save();

        return [
            "success" => true,
            "cart" => json_decode(json_encode($cart), true),
            "message" => "Cart updated successfully!"
        ];


    }

    // Remove products from cart
    public function remove($cart, Request $request) {

        $cart = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();

        if(!$cart){
            return [
                "success" => false,
                "message" => "Cart not available!"
            ];
        }

        $itemToRemove = null;
        foreach ($cart->items as $item) {
            if ((string)$item['product_id'] === (string)$request->product_id) {
                $itemToRemove = $item;
                break;
            }
        }

        if (!$itemToRemove) {
            return [
                "success" => false,
                "message" => "Product not found in cart!"
            ];
        }

        // Restore stock
        $product = Product::query()->where('_id', $request->product_id)->first();
        if ($product) {
            $product->stock += $itemToRemove['quantity'];
            $product->save();
        }

        // Remove the item from cart using $pull
        Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->pull('items', ['product_id' => $request->product_id]);

        // Recalculate total price
        $newTotal = 0;
        $cart = Cart::query()->where('_id', $cart->_id)->first(); // Refresh cart
        foreach ($cart->items as $item) {
            if ((string)$item['product_id'] !== (string)$request->product_id) { // Already removed
                $newTotal += $item['quantity'] * $item['price'];
            }
        }
        $cart->total_price = $newTotal;
        $cart->save();

        return [
            "success" => true,
            "cart" => json_decode(json_encode($cart), true),
            "message" => "Product removed from cart!"
        ];

    }

    // Clear cart and revert products stock
    public function clear($cart, Request $request) {

        $cart = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();

        foreach($cart->items as $item){
            $product = Product::query()->where('_id', new ObjectId($item['product_id']))->first();
            $product->stock += $item['quantity'];
            $product->save();
        }

        return $cart->delete();

    }


}
