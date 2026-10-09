<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('keranjang', []);
        $barang = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            if (! isset($barang[$id])) {
                continue;
            }
            $subtotal = $barang[$id]->harga * $qty;
            $total += $subtotal;
            $items[] = ['barang' => $barang[$id], 'qty' => $qty, 'subtotal' => $subtotal];
        }

        return view('keranjang', [
            'items' => $items,
            'total' => $total,
            'jumlahItem' => array_sum($cart),
        ]);
    }

    public function tambah(Request $request, Product $product)
    {
        $cart = $request->session()->get('keranjang', []);
        $qty = ($cart[$product->id_barang] ?? 0) + 1;

        if ($qty > $product->stok) {
            return back()->with('error', 'Stok '.$product->nama_barang.' tidak mencukupi.');
        }

        $cart[$product->id_barang] = $qty;
        $request->session()->put('keranjang', $cart);

        return back();
    }

    public function ubah(Request $request, Product $product, string $aksi)
    {
        $cart = $request->session()->get('keranjang', []);

        if (isset($cart[$product->id_barang])) {
            $qty = $cart[$product->id_barang] + ($aksi === 'plus' ? 1 : -1);

            if ($qty > $product->stok) {
                return back()->with('error', 'Jumlah melebihi stok '.$product->nama_barang.'.');
            }

            if ($qty <= 0) {
                unset($cart[$product->id_barang]);
            } else {
                $cart[$product->id_barang] = $qty;
            }
        }
        $request->session()->put('keranjang', $cart);

        return back();
    }

    public function hapus(Request $request, Product $product)
    {
        $cart = $request->session()->get('keranjang', []);
        unset($cart[$product->id_barang]);
        $request->session()->put('keranjang', $cart);

        return back();
    }
}
