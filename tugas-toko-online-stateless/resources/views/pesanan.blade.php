@extends('layout')
@section('title', 'Riwayat Pesanan')
@section('content')
    <h2>Riwayat pesanan</h2>
    @if ($pesanan->isEmpty())
        <p>Belum ada pesanan.</p>
    @else
        <table>
            <tr><th>ID Pesanan</th><th>Tanggal</th><th>Total</th><th></th></tr>
            @foreach ($pesanan as $p)
                <tr>
                    <td>{{ $p->id_order }}</td>
                    <td>{{ $p->tanggal_order->format('d-m-Y H:i') }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td><a href="/pesanan/{{ $p->id_order }}">Detail</a></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
