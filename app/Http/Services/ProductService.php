<?php

namespace App\Http\Services;
use App\Models\Product;
use MongoDB\BSON\ObjectId;
class ProductService {

    public function index() {

        return Product::query()->get();

    }

    public function show($product) {

        return Product::query()->find(new ObjectId($product));

    }

    public function store($request) {

        return Product::query()->create($request);

    }

    public function update($request, $product) {

        return Product::query()->where('_id', new ObjectId($product))->first()->update($request);

    }

    public function destroy($product) {

        return Product::destroy(new ObjectId($product));

    }

}
