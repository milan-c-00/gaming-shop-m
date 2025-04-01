<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }
    public function index(Request $request) {

        $products = $this->productService->index();

        if(!$products)
            return response()->json(["message" => "No products found!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "OK!", "products" => $products], ResponseAlias::HTTP_OK);

    }

    public function show($product) {

        $product = $this->productService->show($product);

        if(!$product)
            return response()->json(["message" => "Product not found!"], ResponseAlias::HTTP_NOT_FOUND);
        return response()->json(["message" => "OK!", "product" => $product], ResponseAlias::HTTP_OK);
    }

    public function store(StoreProductRequest $request) {

        $product = $this->productService->store($request->validated());

        if(!$product)
            return response()->json(["message" => "Error!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Product created!"], ResponseAlias::HTTP_CREATED);

    }

    public function update(UpdateProductRequest $request, $product) {

        $updated = $this->productService->update($request->validated(), $product);

        if(!$updated)
            return response()->json(["message" => "Update failed!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Product updated!"], ResponseAlias::HTTP_OK);

    }

    public function destroy($product) {

        $deleted = $this->productService->destroy($product);

        if(!$deleted)
            return response()->json(["message" => "Delete failed!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(["message" => "Product deleted!"], ResponseAlias::HTTP_OK);

    }


}
