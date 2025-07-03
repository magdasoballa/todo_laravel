@extends('app')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">

        <h1 class="text-2xl font-bold mb-6">Twoje zadania</h1>

        {{-- Komunikat sukcesu --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Błędy walidacji --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formularz dodawania zadania --}}
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-6 border p-4 rounded space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-semibold">Nazwa zadania</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full border p-2 rounded"
                    required
                    maxlength="255"
                >
            </div>

            <div>
                <label for="description" class="block font-semibold">Opis (opcjonalnie)</label>
                <textarea
                    name="description"
                    id="description"
                    class="w-full border p-2 rounded"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <div>
                    <label for="priority" class="block font-semibold">Priorytet </label>
                    <select
                        name="priority"
                        id="priority"
                        class="w-full border p-2 rounded"
                        required
                    >
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Niski</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Średni</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Wysoki</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block font-semibold">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full border p-2 rounded"
                        required
                    >
                        <option value="to-do" {{ old('status', 'to-do') == 'to-do' ? 'selected' : '' }}>Do zrobienia</option>
                        <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>W trakcie</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Zrobione</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="due_date" class="block font-semibold">Termin wykonania</label>
                <input
                    type="date"
                    name="due_date"
                    id="due_date"
                    value="{{ old('due_date') }}"
                    class="w-full border p-2 rounded"
                    required
                    min="{{ date('Y-m-d') }}"
                >
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Dodaj zadanie
            </button>
        </form>

        {{-- Lista zadań --}}
        <ul>
            @forelse ($tasks as $task)
                <li class="mb-2 border p-3 rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $task->name }}</strong> – {{ $task->status }} – {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}
                    </div>

                    {{-- Przycisk udostępniania --}}
                    <form action="{{ route('tasks.share', $task->id) }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Udostępnij</button>
                    </form>
                </li>
            @empty
                <li>Brak zadań do wyświetlenia.</li>
            @endforelse
        </ul>

        {{-- Wyświetlanie publicznego linku --}}
        @if (session('public_link'))
            <div class="mt-4 bg-green-100 border p-3 rounded">
                <strong>Publiczny link:</strong>
                <a href="{{ session('public_link') }}" target="_blank" class="underline text-blue-600">{{ session('public_link') }}</a>
            </div>
        @endif

    </div>
@endsection
