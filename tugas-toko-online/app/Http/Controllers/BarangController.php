<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        return view('barang', [
            'barang' => Product::orderBy('id_barang')->get(),
            'jumlahItem' => array_sum($request->session()->get('keranjang', [])),
        ]);
    }
}
