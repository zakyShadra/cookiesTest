<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Alat Tulis</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 640px; margin: 2rem auto; }
        .atas { display: flex; justify-content: space-between; border-bottom: 1px solid #ccc; padding-bottom: .5rem; }
        .baris { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #eee; }
        form { display: inline; }
    </style>
</head>
<body>
    <div class="atas">
        <h2 style="margin:0">Toko Alat Tulis</h2>
        <a href="/keranjang">Keranjang ({{ $jumlahItem }})</a>
    </div>
    <h3>Daftar barang</h3>
    @foreach ($barang as $b)
        <div class="baris">
            <span>{{ $b->nama }} - Rp {{ number_format($b->harga, 0, ',', '.') }}</span>
            <form method="POST" action="/keranjang/tambah/{{ $b->id }}">
                @csrf
                <button type="submit">Masukkan ke keranjang</button>
            </form>
        </div>
    @endforeach
</body>
</html>
