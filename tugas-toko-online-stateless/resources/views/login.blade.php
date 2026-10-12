@extends('layout')
@section('title', 'Login')
@section('content')
    <h2>Login</h2>
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="/login">
        @csrf
        <p>Username<br><input type="text" name="username" value="{{ old('username') }}"></p>
        <p>Password<br><input type="password" name="password"></p>
        <button type="submit">Masuk</button>
    </form>
@endsection
