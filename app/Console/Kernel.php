<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Notifications\TaskDueNotification;
use App\Notifications\TaskReminderNotification;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tasks = Task::with('user')
                ->whereDate('due_date', Carbon::tomorrow())
                ->get();

            foreach ($tasks as $task) {
                if ($task->user && $task->user->email) {
                    $task->user->notify(new TaskReminderNotification($task));
                }
            }
        })->daily();
    }
}
