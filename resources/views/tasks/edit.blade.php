@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-2xl font-bold mb-6">Edytuj zadanie</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="mb-6 border p-4 rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold">Nazwa zadania</label>
                <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}"
                       class="w-full border p-2 rounded" required maxlength="255">
            </div>

            <div>
                <label for="description" class="block font-semibold">Opis (opcjonalnie)</label>
                <textarea name="description" id="description"
                          class="w-full border p-2 rounded">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="flex gap-4">
                <div>
                    <label for="priority" class="block font-semibold">Priorytet</label>
                    <select name="priority" id="priority" class="w-full border p-2 rounded" required>
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Niski
                        </option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>
                            Średni
                        </option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Wysoki
                        </option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block font-semibold">Status</label>
                    <select name="status" id="status" class="w-full border p-2 rounded" required>
                        <option value="to-do" {{ old('status', $task->status) == 'to-do' ? 'selected' : '' }}>Do
                            zrobienia
                        </option>
                        <option
                            value="in-progress" {{ old('status', $task->status) == 'in-progress' ? 'selected' : '' }}>W
                            trakcie
                        </option>
                        <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Zrobione
                        </option>
                    </select>
                </div>
            </div>

            <div>
                <label for="due_date" class="block font-semibold">Termin wykonania</label>
                <input type="date" name="due_date" id="due_date"
                       value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" class="w-full border p-2 rounded"
                       required min="{{ date('Y-m-d') }}">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Zapisz zmiany</button>
            <a href="{{ route('tasks.index') }}" class="ml-4 text-gray-600">Anuluj</a>
        </form>
    </div>
@endsection
