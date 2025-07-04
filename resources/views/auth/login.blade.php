@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="container">
        <h1 class="title">Logowanie</h1>

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />

            <label for="password">Hasło</label>
            <input id="password" type="password" name="password" required />

            <button type="submit" class="btn">Zaloguj się</button>
        </form>

        <p class="mt-4">
            <a href="{{ route('password.request') }}" class="link">Zapomniałeś hasła?</a>
        </p>

        <p class="mt-2">
            Nie masz konta?
            <a href="{{ route('register') }}" class="link">Zarejestruj się</a>
        </p>
    </div>
@endsection
