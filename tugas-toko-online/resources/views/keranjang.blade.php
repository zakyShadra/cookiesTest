@extends('layout')
@section('title', 'Keranjang')
@section('content')
    <h2>Keranjang belanja</h2>

    @forelse ($items as $item)
        <div class="baris">
            <span>
                {{ $item['barang']->nama_barang }}<br>
                Rp {{ number_format($item['barang']->harga, 0, ',', '.') }} x {{ $item['qty'] }} = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </span>
            <span>
                <form method="POST" action="/keranjang/ubah/{{ $item['barang']->id_barang }}/minus">@csrf <button type="submit">-</button></form>
                {{ $item['qty'] }}
                <form method="POST" action="/keranjang/ubah/{{ $item['barang']->id_barang }}/plus">@csrf <button type="submit">+</button></form>
                <form method="POST" action="/keranjang/hapus/{{ $item['barang']->id_barang }}">@csrf <button type="submit">hps</button></form>
            </span>
        </div>
    @empty
        <p>Keranjang masih kosong. <a href="/barang">Lihat daftar barang</a></p>
    @endforelse

    @if (count($items))
        <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
        <form method="POST" action="/checkout">
            @csrf
            <p>Alamat pengiriman<br>
                <textarea name="alamat_pengiriman" rows="3" cols="50">{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>
            </p>
            <button type="submit">Checkout</button>
        </form>
    @endif
@endsection
