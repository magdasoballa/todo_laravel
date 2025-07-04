<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Wyślij przypomnienia o zadaniach zaplanowanych na jutro';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $tasks = Task::whereDate('due_date', $tomorrow)->get();

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                $task->user->notify(new TaskReminderNotification($task));
            }
        }

        $this->info('Powiadomienia zostały wysłane.');
    }
}
