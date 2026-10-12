@extends('layout')
@section('title', 'Daftar Barang')
@section('content')
    <h2>Daftar barang</h2>
    <div class="grid">
        @foreach ($barang as $b)
            <div class="kartu">
                <img src="/images/{{ $b->gambar }}" alt="{{ $b->nama_barang }}">
                <h3>{{ $b->nama_barang }}</h3>
                <p>{{ $b->deskripsi }}</p>
                <p>Rp {{ number_format($b->harga, 0, ',', '.') }}<br>Stok: {{ $b->stok }}</p>
                @if ($b->stok <= 0)
                    <button disabled>Stok habis</button>
                @elseif (auth()->check())
                    <form method="POST" action="/keranjang/tambah/{{ $b->id_barang }}">
                        @csrf
                        <button type="submit">Masukkan ke keranjang</button>
                    </form>
                @else
                    <a href="/login">Login untuk membeli</a>
                @endif
            </div>
        @endforeach
    </div>
@endsection
