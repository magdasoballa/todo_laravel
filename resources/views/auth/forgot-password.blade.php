@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="auth-container">
        <h1 class="auth-title">Zapomniałeś hasła?</h1>
        <p class="mb-4  text-gray-600">
            Wpisz swój adres e-mail, a wyślemy Ci link do zresetowania hasła.
        </p>

        @if (session('status'))
            <div class="alert success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" class="auth-input" value="{{ old('email') }}" required autofocus />

            <button type="submit" class="btn blue">Wyślij link do resetu hasła</button>
        </form>

        <p class="auth-extra">
            <a href="{{ route('login') }}" class="link">Powrót do logowania</a>
        </p>
    </div>
@endsection
