<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        return view('index', [
            'barang' => Barang::all(),
            'jumlahItem' => array_sum($request->session()->get('keranjang', [])),
        ]);
    }

    public function keranjang(Request $request)
    {
        $cart = $request->session()->get('keranjang', []);
        $barang = Barang::whereIn('id', array_keys($cart))->get()->keyBy('id');

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

    public function tambah(Request $request, Barang $barang)
    {
        $cart = $request->session()->get('keranjang', []);
        $cart[$barang->id] = ($cart[$barang->id] ?? 0) + 1;
        $request->session()->put('keranjang', $cart);

        return back();
    }

    public function ubah(Request $request, Barang $barang, string $aksi)
    {
        $cart = $request->session()->get('keranjang', []);

        if (isset($cart[$barang->id])) {
            $cart[$barang->id] += $aksi === 'plus' ? 1 : -1;
            if ($cart[$barang->id] <= 0) {
                unset($cart[$barang->id]);
            }
        }
        $request->session()->put('keranjang', $cart);

        return back();
    }

    public function hapus(Request $request, Barang $barang)
    {
        $cart = $request->session()->get('keranjang', []);
        unset($cart[$barang->id]);
        $request->session()->put('keranjang', $cart);

        return back();
    }

    public function kosongkan(Request $request)
    {
        $request->session()->forget('keranjang');

        return back();
    }
}
