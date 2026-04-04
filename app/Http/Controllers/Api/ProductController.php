<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select(
            'id', 'name', 'description', 
            'price', 'stock', 'category', 'image'
        )->get();

        return response()->json(['data' => $products]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['data' => $product]);
    }
}