<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEmployeeAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $employee;

    /**
     * Create a new notification instance.
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Employee Added')
            ->greeting('Hello!')
            ->line('A new employee has been added.')
            ->line('First Name: ' . $this->employee->first_name)
            ->line('Last Name: ' . $this->employee->last_name)
            ->line('Email: ' . $this->employee->email)
            ->line('Phone: ' . $this->employee->phone)
            ->line('Thank you for using our application!');
    }
}
