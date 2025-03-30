<?php

namespace App\Http\Services;
use App\Models\Product;

class ProductService {

    public function index() {
        return null;
    }

    public function show() {
        return null;
    }

    public function store($request) {

        return Product::query()->create($request);

//        return Product::query()->create([
//            'name' => $request['name'],
//            'category' => $request['category'],
//            'price' => $request['price'],
//            'stock' => $request['stock'],
//            'description' => $request['description'],
//            'platform' => $request[''],
//            'release_date' => $request['release_date'],
//
//        ]);

    }

    public function update() {

    }

    public function destroy() {
        return null;
    }

}
