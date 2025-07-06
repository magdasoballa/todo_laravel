<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        $tasks = $query->orderBy('due_date')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function share($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        if (!$task->access_token || $task->token_expires_at < now()) {
            $task->access_token = Str::uuid();
            $task->token_expires_at = now()->addMinute();
            $task->save();
        }

        $link = url('/public/task/' . $task->access_token);

        return redirect()->route('tasks.index')->with('public_link', $link);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'status' => ['required', Rule::in(['to-do', 'in-progress', 'done'])],
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = auth()->user()->tasks()->create($validated);

//        if (session()->has('google_token')) {
//            $event = new Event;
//
//            $event->name = $task->name;
//            $event->description = $task->description ?? '';
//            $event->startDateTime = Carbon::parse($task->due_date)->setTime(9, 0, 0);
//            $event->endDateTime = Carbon::parse($task->due_date)->setTime(10, 0, 0);
//
//            $event->save();
//        }

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało dodane');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'status' => ['required', Rule::in(['to-do', 'in-progress', 'done'])],
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'name' => $task->name,
            'description' => $task->description,
            'priority' => $task->priority,
            'status' => $task->status,
            'due_date' => $task->due_date,
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało zaktualizowane');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało usunięte');
    }
}
