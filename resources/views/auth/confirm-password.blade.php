@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto p-6 bg-white rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Potwierdź swoje hasło</h1>
        <p class="mb-6 text-gray-700">
            To jest bezpieczny obszar aplikacji. Proszę potwierdź swoje hasło, aby kontynuować.
        </p>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Hasło</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    autofocus
                    class="w-full border px-3 py-2 rounded"
                    placeholder="Hasło"
                />
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded">
                Potwierdź hasło
            </button>
        </form>
    </div>
@endsection
