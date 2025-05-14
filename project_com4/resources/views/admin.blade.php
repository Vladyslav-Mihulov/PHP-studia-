@extends('layouts.main')

@section('title')
    <h1>Strona dla admina</h1>
@endsection

@section('content')
    <h2>Lista użytkowników</h2>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Email</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Role</th>
                <th>Dodany przez</th>
                <th>Zmodyfikowany przez</th>
                <th>Utworzono</th>
                <th>Zmodyfikowano</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id_user }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>
                        @forelse($user->roles as $role)
                            <span>{{ $role->role_name }}</span><br />
                        @empty
                            Brak ról
                        @endforelse
                    </td>
                    <td>{{ $user->who_created }}</td>
                    <td>{{ $user->who_modify }}</td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
