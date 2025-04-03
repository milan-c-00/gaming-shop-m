<?php

namespace App\Http\Services;

use App\Models\Cart;
use MongoDB\BSON\ObjectId;

class CartService {

    public function show($cart) {

        return Cart::query()->find(new ObjectId($cart))->first();

    }

    public function add() {

        return null;

    }

    public function update($cart) {

        return null;

    }

    public function remove() {

        return null;

    }

    public function clear() {

        return null;

    }


}
