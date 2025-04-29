<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Services\CartService;
use http\Env\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    public function add(AddToCartRequest $request) {

        $response = $this->cartService->add($request);

        if(!$response["success"])
            return response()->json(["message" => $response["message"]], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => $response["message"], "cart" => $response["cart"]], ResponseAlias::HTTP_OK);

    }

    public function show(Request $request, $cart) {

        $cart = $this->cartService->show($cart);

        if(!$cart)
            return response()->json(["message" => "No cart!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "OK!", "cart" => $cart], ResponseAlias::HTTP_OK);

    }

    public function update($cart, UpdateCartRequest $request) {

        $response = $this->cartService->update($cart, $request);

        if(!$response["success"])
            return response()->json(["message" => $response["message"]], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => $response["message"], "cart" => $response["cart"]], ResponseAlias::HTTP_OK);

    }

    public function remove($cart, Request $request) {

        $removed = $this->cartService->remove($cart, $request);

        if(!$removed)
            return response()->json(["message" => "Error!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Removed!"], ResponseAlias::HTTP_OK);

    }

    public function clear($cart, Request $request) {

        $cleared = $this->cartService->clear($cart, $request);

        if(!$cleared)
            return response()->json(["message" => "Error!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Cart cleared!"], ResponseAlias::HTTP_OK);

    }

}
