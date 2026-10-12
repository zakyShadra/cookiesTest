<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate(['alamat_pengiriman' => ['required', 'string']]);

        $cart = $request->session()->get('keranjang', []);
        if (! $cart) {
            return redirect('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $barang = Product::whereIn('id_barang', array_keys($cart))->lockForUpdate()->get()->keyBy('id_barang');

            foreach ($cart as $id => $qty) {
                if (! isset($barang[$id]) || $barang[$id]->stok < $qty) {
                    return null;
                }
            }

            $total = 0;
            foreach ($cart as $id => $qty) {
                $total += $barang[$id]->harga * $qty;
            }

            $order = Order::create([
                'id_order' => 'ORD'.now()->format('ymdHis'),
                'id_user' => Auth::id(),
                'tanggal_order' => now(),
                'total_harga' => $total,
                'alamat_pengiriman' => $request->alamat_pengiriman,
            ]);

            foreach ($cart as $id => $qty) {
                $order->details()->create([
                    'id_barang' => $id,
                    'harga_satuan' => $barang[$id]->harga,
                    'jumlah_beli' => $qty,
                ]);
                $barang[$id]->decrement('stok', $qty);
            }

            return $order;
        });

        if (! $order) {
            return redirect('/keranjang')->with('error', 'Stok sebagian barang tidak mencukupi. Periksa kembali keranjang Anda.');
        }

        $request->session()->forget('keranjang');

        return redirect('/pesanan/'.$order->id_order);
    }

    public function index()
    {
        return view('pesanan', [
            'pesanan' => Auth::user()->orders()->orderByDesc('tanggal_order')->get(),
        ]);
    }

    public function show(string $id)
    {
        $order = Auth::user()->orders()->with('details.product')->findOrFail($id);

        return view('pesanan_detail', ['order' => $order]);
    }
}
