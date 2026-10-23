@extends('layout')
@section('title', 'Kelola Role')
@section('content')
    <h2>Kelola role pengguna</h2>

    @if (session('status'))
        <div style="background:#dcfce7;color:#166534;padding:.5rem;margin-bottom:1rem;">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <table>
        <tr>
            <th>ID User</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role saat ini</th>
            <th>Ubah role</th>
        </tr>
        @foreach ($users as $u)
            <tr>
                <td>{{ $u->id_user }}</td>
                <td>{{ $u->nama_lengkap }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if ($u->is(auth()->user()) || $u->role === 'admin')
                        <em>tidak dapat diubah di sini</em>
                    @else
                        <form method="POST" action="{{ route('admin.users.role.update', $u) }}">
                            @csrf
                            @method('PATCH')
                            <select name="role">
                                <option value="customer" @selected($u->role === 'customer')>customer</option>
                                <option value="staff" @selected($u->role === 'staff')>staff</option>
                            </select>
                            <button type="submit">Simpan</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
