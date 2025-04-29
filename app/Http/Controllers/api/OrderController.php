<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Services\OrderService;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\Builder\Stage\ReplaceRootStage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function Symfony\Component\Translation\t;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index() {

        $orders = $this->orderService->index();
        if(!$orders)
            return response()->json(["message" => "No orders found!"], ResponseAlias::HTTP_OK);
        return response()->json(["message" => "OK!", "orders" => $orders], ResponseAlias::HTTP_OK);

    }

    // Order checkout
    public function store(Request $request) {

    $response = $this->orderService->store($request);
    if(!$response['success'])
        return response()->json(["message" => $response["message"]], ResponseAlias::HTTP_OK);
    return response()->json(["message" => $response["message"], "order" => $response["order"]], ResponseAlias::HTTP_OK);

    }

    public function show($order) {

        $order = $this->orderService->show($order);
        if(!$order)
            return response()->json(["message" => "Order not found!"], ResponseAlias::HTTP_OK);
        return response()->json(["message" => "OK!", "order" => $order], ResponseAlias::HTTP_OK);

    }

    public function update() {

    }

    public function destroy() {

        $deleted = $this->orderService->destroy();
        if(!$deleted)
            return response()->json(["message" => "Delete failed!"], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(["message" => "Order deleted!"], ResponseAlias::HTTP_OK);

    }

    public function myOrders(Request $request) {

        $myOrders = $this->orderService->myOrders($request);
        if(!$myOrders)
            return response()->json(["message" => "No orders found!"], ResponseAlias::HTTP_OK);
        return response()->json(["message" => "OK!", "my_orders" => $myOrders], ResponseAlias::HTTP_OK);
    }

}
