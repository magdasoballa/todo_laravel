@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Resetowanie hasła</h1>
    <p class="mb-6 text-gray-600">Wpisz nowe hasło poniżej, aby zresetować swoje konto.</p>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4 max-w-md">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="password" class="block font-semibold mb-1">Nowe hasło</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full border px-3 py-2 rounded" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-semibold mb-1">Potwierdź hasło</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   autocomplete="new-password"
                   class="w-full border px-3 py-2 rounded" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Zresetuj hasło
        </button>
    </form>

    <div class="mt-6 text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Powrót do logowania</a>
    </div>
@endsection
