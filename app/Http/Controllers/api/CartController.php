<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    public function add(Request $request) {

    }

    public function show(Request $request, $cart) {

        $cart = $this->cartService->show($cart);

        if(!$cart)
            return response()->json(["message" => "No cart!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "OK!", "cart" => $cart], ResponseAlias::HTTP_OK);

    }

    public function update($cart) {

        $updated = $this->cartService->update($cart);

        if(!$updated)
            return response()->json(["message" => "Update failed!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "OK!"], ResponseAlias::HTTP_OK);

    }

    public function remove($cart) {

        $removed = $this->cartService->remove($cart);

        if(!$removed)
            return response()->json(["message" => "Error!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Removed!"], ResponseAlias::HTTP_OK);

    }

    public function clear() {

    }

}
