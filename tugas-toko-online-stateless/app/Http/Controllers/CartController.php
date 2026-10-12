<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    private $products = [
        1 => ['id' => 1, 'name' => 'Buku Tulis', 'price' => 5000],
        2 => ['id' => 2, 'name' => 'Pulpen', 'price' => 3000],
        3 => ['id' => 3, 'name' => 'Penggaris', 'price' => 4000],
    ];

    public function index()
    {
        return view('shop', ['products' => $this->products]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'cart' => 'nullable|array',
        ]);

        $productId = (int) $request->product_id;
        $cart = $request->cart ?? [];

        if (!isset($this->products[$productId])) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        $cart[$productId] = isset($cart[$productId]) ? $cart[$productId] + 1 : 1;

        return response()->json($this->cartResponse($cart));
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'cart' => 'nullable|array',
        ]);

        $productId = (int) $request->product_id;
        $cart = $request->cart ?? [];

        if (!isset($this->products[$productId])) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        $cart[$productId] = (int) $request->quantity;

        return response()->json($this->cartResponse($cart));
    }

    private function cartResponse($cart)
    {
        $items = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            if (!isset($this->products[$id])) {
                continue;
            }

            $product = $this->products[$id];
            $subtotal = $product['price'] * $quantity;

            $items[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        return ['items' => $items, 'total' => $total];
    }
}
