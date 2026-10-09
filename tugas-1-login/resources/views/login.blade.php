<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); width: 320px; }
        h1 { margin: 0 0 .25rem; font-size: 1.5rem; }
        .subtitle { margin: 0 0 1rem; color: #64748b; font-size: .9rem; }
        .error { background: #fee2e2; color: #991b1b; padding: .6rem .8rem; border-radius: 6px; font-size: .85rem; margin-bottom: 1rem; }
        label { display: block; margin-bottom: .25rem; font-size: .85rem; font-weight: bold; }
        input { width: 100%; padding: .5rem; margin-bottom: 1rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: .6rem; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <p class="subtitle">Masuk untuk membuka dashboard</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>
