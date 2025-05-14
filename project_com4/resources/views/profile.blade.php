@extends('layouts.main')

@section('title')
<h1> Twój profil <br /> </h1>
@endsection

@section('content')
<section id="profile">
    <div class="content">
        <h2>Informacje o użytkowniku</h2>
        
        <p><strong>Login:</strong> {{ $user->login }}</p>
        <p><strong>Email:</strong> {{ $user->email }} </p>
        <p><strong>Imię:</strong> {{ $user->first_name }}</p>
        <p><strong>Nazwisko:</strong> {{ $user->last_name }} </p>
        <p><strong>Twoja rola:</strong> 
                @if(count($roles) > 0)
                    {{ implode(', ', $roles) }}
                @else
                    Brak ról
                @endif
            </p>


    </div>
    <div class="pure-controls" style="display: flex; gap: 10px;" >
                       <button type="button" onclick="window.location.href='{{ route('logout') }}'" class="pure-button pure-button-primary">WYLOGUJ SIĘ</button>
                </div>

</section>
@endsection
