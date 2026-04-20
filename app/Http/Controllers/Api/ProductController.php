<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StripeService;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select(
            'id',
            'name',
            'description',
            'price',
            'stock',
            'category',
            'image',
            'spline_url'
        )->get();

        return response()->json(['data' => $products]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['data' => $product]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'email'            => 'nullable|email',
        ]);

        $email = $request->email;
        if (!$email) {
            return response()->json(['error' => 'Introduce un email para continuar.'], 422);
        }

        foreach ($request->items as $item) {
            $product = DB::table('products')->where('id', $item['id'])->first();
            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'error' => "Stock insuficiente para \"{$product->name}\". Solo quedan {$product->stock}."
                ], 422);
            }
        }

        $total = 0;
        foreach ($request->items as $item) {
            $product = DB::table('products')->where('id', $item['id'])->first();
            $total += $product->price * $item['quantity'];
        }

        $concepto = count($request->items) === 1
            ? $request->items[0]['name']
            : count($request->items) . ' productos del Zoo';

        try {
            $stripe  = new StripeService();
            $session = $stripe->createCheckoutSession([
                'email'    => $email,
                'amount'   => $total,
                'concepto' => $concepto,
                'tipo'     => 'shop',
                'meta'     => ['items' => $request->items],
                'return_url' => route('tienda'),
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
