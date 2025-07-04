@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@endpush

@section('content')
    <div class="container">
        <h1 class="title">Twoje zadania</h1>

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
            @csrf

            <label for="name">Nazwa zadania</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255">

            <label for="description">Opis (opcjonalnie)</label>
            <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>

            <div class="row">
                <div>
                    <label for="priority">Priorytet</label>
                    <select name="priority" id="priority" required>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Niski</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Średni</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Wysoki</option>
                    </select>
                </div>

                <div>
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="to-do" {{ old('status', 'to-do') == 'to-do' ? 'selected' : '' }}>Do zrobienia</option>
                        <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>W trakcie</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Zrobione</option>
                    </select>
                </div>
            </div>

            <label for="due_date">Termin wykonania</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required min="{{ date('Y-m-d') }}">

            <button type="submit" class="btn green">Dodaj zadanie</button>
        </form>

        <ul class="task-list">
            @forelse ($tasks as $task)
                <li class="task-item">
                    <div>
                        <strong>{{ $task->name }}</strong><br>
                        <small>{{ $task->status }} — termin: {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</small>
                    </div>
                    <div class="actions">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn yellow">Edytuj</a>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Na pewno usunąć zadanie?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn red">Usuń</button>
                        </form>

                        <form action="{{ route('tasks.share', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn blue">Udostępnij</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="empty">Brak zadań do wyświetlenia.</li>
            @endforelse
        </ul>

        @if (session('public_link'))
            <div class="shared-link">
                <strong>Publiczny link:</strong><br>
                <a href="{{ session('public_link') }}" target="_blank">{{ session('public_link') }}</a>
            </div>
        @endif
    </div>
@endsection
