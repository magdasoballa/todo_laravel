<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskReminderNotification extends Notification
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Przypomnienie o zadaniu')
            ->line("Masz zaplanowane zadanie na jutro: {$this->task->name}")
            ->line("Opis: {$this->task->description}")
            ->line("Termin: {$this->task->due_date->format('Y-m-d')}")
            ->action('Zobacz zadanie', url(route('tasks.index')))
            ->line('Nie zapomnij go wykonać!');
    }
}
