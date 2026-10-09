<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; margin: 0; }
        header { background: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; }
        header h1 { margin: 0; font-size: 1.25rem; }
        main { max-width: 600px; margin: 2rem auto; background: #fff; padding: 1.5rem 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        form { margin: 0; }
        button { padding: .4rem 1rem; background: #dc2626; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #b91c1c; }
        .muted { color: #64748b; }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </header>
    <main>
        <p>Selamat datang, {{ $user->nama_lengkap }}!</p>
        <p class="muted">Halaman ini hanya bisa dibuka setelah login.</p>
        <p>Username: {{ $user->username }}</p>
    </main>
</body>
</html>
