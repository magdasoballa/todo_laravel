@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@endpush

@section('content')
    <div class="container">
        <h1 class="title">Edytuj zadanie</h1>

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="task-form">
            @csrf
            @method('PUT')

            <label for="name">Nazwa zadania</label>
            <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" required maxlength="255">

            <label for="description">Opis (opcjonalnie)</label>
            <textarea name="description" id="description" rows="3">{{ old('description', $task->description) }}</textarea>

            <div class="row">
                <div>
                    <label for="priority">Priorytet</label>
                    <select name="priority" id="priority" required>
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Niski</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Średni</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Wysoki</option>
                    </select>
                </div>

                <div>
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="to-do" {{ old('status', $task->status) == 'to-do' ? 'selected' : '' }}>Do zrobienia</option>
                        <option value="in-progress" {{ old('status', $task->status) == 'in-progress' ? 'selected' : '' }}>W trakcie</option>
                        <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Zrobione</option>
                    </select>
                </div>
            </div>

            <label for="due_date">Termin wykonania</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" required min="{{ date('Y-m-d') }}">

            <button type="submit" class="btn blue">Zapisz zmiany</button>
            <a href="{{ route('tasks.index') }}" class="link" style="margin-left: 1rem;">Anuluj</a>
        </form>
        @if ($task->histories->count())
            <div class="task-history mt-5">
                <h2>Historia zmian</h2>
                <ul class="history-list">
                    @foreach ($task->histories as $history)
                        <li>
                            <strong>{{ $history->updated_at->format('Y-m-d H:i') }}</strong>:
                            {{ $history->name }} –
                            {{ ucfirst($history->status) }},
                            priorytet: {{ ucfirst($history->priority) }},
                            termin: {{ \Carbon\Carbon::parse($history->due_date)->format('Y-m-d') }}

                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
