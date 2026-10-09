@extends('layout')
@section('title', 'Detail Pesanan')
@section('content')
    <h2>Detail pesanan {{ $order->id_order }}</h2>
    <p>Tanggal: {{ $order->tanggal_order->format('d-m-Y H:i') }}<br>
        Alamat pengiriman: {{ $order->alamat_pengiriman }}</p>
    <table>
        <tr><th>Barang</th><th>Harga satuan</th><th>Jumlah</th><th>Subtotal</th></tr>
        @foreach ($order->details as $d)
            <tr>
                <td>{{ $d->product->nama_barang }}</td>
                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $d->jumlah_beli }}</td>
                <td>Rp {{ number_format($d->harga_satuan * $d->jumlah_beli, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <h3>Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h3>
    <a href="/pesanan">Kembali ke riwayat</a>
@endsection
