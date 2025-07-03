<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicTaskController extends Controller
{
public function show($token)
{
$task = Task::where('access_token', $token)
->where('token_expires_at', '>', now())
->firstOrFail();

return view('tasks.public_show', compact('task'));
}
}
