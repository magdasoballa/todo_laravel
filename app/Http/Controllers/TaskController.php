<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    public function share($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        $task->access_token = Str::uuid();
        $task->token_expires_at = Carbon::now()->addHours(24);
        $task->save();

        $link = url('/public/task/' . $task->access_token);

        // Możesz przekierować z komunikatem flash:
        return redirect()->route('tasks.index')->with('public_link', $link);

        // Jeśli chcesz zwracać JSON (np. do ajax), to wtedy:
        // return response()->json(['public_link' => $link]);
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

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało dodane');
    }
}
