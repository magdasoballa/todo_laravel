<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Rejestracja komend Artisan (jeśli dodajesz własne).
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    /**
     * Harmonogram zadań aplikacji.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Zadanie: Wysyłanie przypomnień o zadaniach, które mają termin jutro
        $schedule->call(function () {
            $tasks = Task::with('user')
                ->whereDate('due_date', Carbon::tomorrow())
                ->get();

            foreach ($tasks as $task) {
                // Wysyłamy przypomnienie użytkownikowi o zadaniu
                $task->user->notify(new TaskDueNotification($task));
            }
        })->daily(); // Uruchamiane raz dziennie
    }
}
