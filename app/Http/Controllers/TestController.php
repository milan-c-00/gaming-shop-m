<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request) {
        $test = new Test;

        $test->text = $request->text;
        $test->number = $request->number;

        $test->save();

        return response()->json(["result" => "ok"], 201);

    }
}
