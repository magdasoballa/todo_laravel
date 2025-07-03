@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-3xl bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-extrabold mb-8 text-gray-800">Twoje zadania</h1>

        {{-- Komunikat sukcesu --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Błędy walidacji --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded shadow">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formularz dodawania zadania --}}
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-8 space-y-6 border border-gray-300 rounded-lg p-6 shadow-sm bg-gray-50">
            @csrf

            <div>
                <label for="name" class="block mb-1 font-semibold text-gray-700">Nazwa zadania</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                    required
                    maxlength="255"
                >
            </div>

            <div>
                <label for="description" class="block mb-1 font-semibold text-gray-700">Opis (opcjonalnie)</label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-6">
                <div class="flex-1">
                    <label for="priority" class="block mb-1 font-semibold text-gray-700">Priorytet</label>
                    <select
                        name="priority"
                        id="priority"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required
                    >
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Niski</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Średni</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Wysoki</option>
                    </select>
                </div>

                <div class="flex-1">
                    <label for="status" class="block mb-1 font-semibold text-gray-700">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required
                    >
                        <option value="to-do" {{ old('status', 'to-do') == 'to-do' ? 'selected' : '' }}>Do zrobienia</option>
                        <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>W trakcie</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Zrobione</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="due_date" class="block mb-1 font-semibold text-gray-700">Termin wykonania</label>
                <input
                    type="date"
                    name="due_date"
                    id="due_date"
                    value="{{ old('due_date') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                    required
                    min="{{ date('Y-m-d') }}"
                >
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded shadow transition duration-150">
                Dodaj zadanie
            </button>
        </form>

        {{-- Lista zadań --}}
        <ul class="space-y-4">
            @forelse ($tasks as $task)
                <li class="border border-gray-300 rounded-lg p-4 flex justify-between items-center shadow-sm hover:shadow-md transition">
                    <div>
                        <strong class="text-lg text-gray-800">{{ $task->name }}</strong><br>
                        <span class="text-sm text-gray-600 capitalize">
                        {{ $task->status }} &mdash; termin: {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}
                    </span>
                    </div>

                    <div class="flex gap-2 text-sm">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow-sm transition">
                            Edytuj
                        </a>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Na pewno usunąć zadanie?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow-sm transition">
                                Usuń
                            </button>
                        </form>

                        <form action="{{ route('tasks.share', $task->id) }}" method="POST" class="">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow-sm transition">
                                Udostępnij
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="text-gray-500 italic">Brak zadań do wyświetlenia.</li>
            @endforelse
        </ul>

        {{-- Wyświetlanie publicznego linku --}}
        @if (session('public_link'))
            <div class="mt-6 p-4 bg-green-100 border border-green-300 rounded shadow">
                <strong class="block mb-2 text-green-800">Publiczny link:</strong>
                <a href="{{ session('public_link') }}" target="_blank" class="underline text-blue-600 hover:text-blue-800">
                    {{ session('public_link') }}
                </a>
            </div>
        @endif
    </div>
@endsection
