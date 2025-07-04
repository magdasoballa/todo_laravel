@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="container">
        <h1 class="title">Rejestracja</h1>

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <label for="name">Imię i nazwisko</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required />

            <label for="email">Adres e-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required />

            <label for="password">Hasło</label>
            <input type="password" id="password" name="password" required />

            <label for="password_confirmation">Potwierdź hasło</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required />

            <button type="submit" class="btn">Zarejestruj się</button>
        </form>

        <p class="mt-2 text-center">
            Masz już konto?
            <a href="{{ route('login') }}">Zaloguj się</a>
        </p>
    </div>
@endsection
