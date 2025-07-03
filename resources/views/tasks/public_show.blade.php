<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie publiczne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h2>Zadanie publiczne</h2>

<div class="card mt-3">
    <div class="card-body">
        <h4 class="card-title">{{ $task->name }}</h4>
        <p class="card-text"><strong>Opis:</strong> {{ $task->description ?? 'Brak' }}</p>
        <p><strong>Priorytet:</strong> {{ ucfirst($task->priority) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
        <p><strong>Termin:</strong> {{ $task->due_date }}</p>
    </div>
</div>
</body>
</html>
