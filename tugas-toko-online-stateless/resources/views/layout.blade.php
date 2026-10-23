<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Toko Alat Tulis</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 860px; margin: 1.5rem auto; padding: 0 1rem; }
        nav { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: .5rem; margin-bottom: 1rem; }
        nav a { margin-right: .75rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 1rem; }
        .kartu { border: 1px solid #ddd; padding: .5rem; }
        .kartu img { width: 100%; }
        .baris { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #eee; }
        .error { background: #fee2e2; color: #991b1b; padding: .5rem; margin-bottom: 1rem; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #ddd; padding: .4rem; text-align: left; }
        form { display: inline; }
    </style>
</head>
<body>
    <nav>
        <span>
            <strong>Toko Alat Tulis</strong>
            <a href="/barang">Barang</a>
            @auth
                <a href="/keranjang">Keranjang ({{ array_sum(session('keranjang', [])) }})</a>
                <a href="/pesanan">Pesanan</a>
            @endauth
            @can('manage-roles')
                <a href="/admin/users">Kelola Role</a>
            @endcan
        </span>
        <span>
            @auth
                {{ auth()->user()->nama_lengkap }}
                <form method="POST" action="/logout">@csrf <button type="submit">Logout</button></form>
            @else
                <a href="/login">Login</a>
            @endauth
        </span>
    </nav>

    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @yield('content')
</body>
</html>
