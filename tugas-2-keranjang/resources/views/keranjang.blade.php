<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 640px; margin: 2rem auto; }
        .atas { display: flex; justify-content: space-between; border-bottom: 1px solid #ccc; padding-bottom: .5rem; }
        .baris { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #eee; }
        form { display: inline; }
    </style>
</head>
<body>
    <div class="atas">
        <h2 style="margin:0">Keranjang belanja</h2>
        <span>Tanpa login | <a href="/index">Daftar barang</a> | Keranjang ({{ $jumlahItem }})</span>
    </div>

    @forelse ($items as $item)
        <div class="baris">
            <span>
                {{ $item['barang']->nama }}<br>
                Rp {{ number_format($item['barang']->harga, 0, ',', '.') }} x {{ $item['qty'] }} = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </span>
            <span>
                <form method="POST" action="/keranjang/ubah/{{ $item['barang']->id }}/minus">@csrf <button type="submit">-</button></form>
                {{ $item['qty'] }}
                <form method="POST" action="/keranjang/ubah/{{ $item['barang']->id }}/plus">@csrf <button type="submit">+</button></form>
                <form method="POST" action="/keranjang/hapus/{{ $item['barang']->id }}">@csrf <button type="submit">hps</button></form>
            </span>
        </div>
    @empty
        <p>Keranjang masih kosong.</p>
    @endforelse

    @if (count($items))
        <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
        <form method="POST" action="/keranjang/kosongkan">@csrf <button type="submit">Kosongkan keranjang</button></form>
    @endif
</body>
</html>
