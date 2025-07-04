@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Zapomniałeś hasła?</h1>
    <p class="mb-6 text-gray-600">Wpisz swój adres e-mail, a wyślemy Ci link do zresetowania hasła.</p>

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 max-w-md">
        @csrf

        <div>
            <label for="email" class="block font-semibold mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border px-3 py-2 rounded" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Wyślij link do resetu hasła
        </button>
    </form>

    <div class="mt-6 text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Powrót do logowania</a>
    </div>
@endsection
