@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 space-y-6 text-center">
        <h1 class="text-2xl font-bold">Weryfikacja adresu e-mail</h1>

        <p class="text-gray-700">
            Prosimy o potwierdzenie adresu e-mail, klikając link, który został do Ciebie wysłany.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                Nowy link weryfikacyjny został wysłany na Twój adres e-mail.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
                Wyślij ponownie e-mail weryfikacyjny
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button
                type="submit"
                class="text-sm text-gray-600 underline hover:text-gray-900"
            >
                Wyloguj się
            </button>
        </form>
    </div>
@endsection
