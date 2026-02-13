<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRequisitionSubmitted extends Notification
{
    use Queueable;

    public $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable): array
    {
        return ['mail']; // We can add 'database' later for in-app alerts
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Fund Request: ₦' . number_format($this->requisition->amount, 2))
            ->greeting('Hello, ' . $notifiable->name)
            ->line('A new fund request has been submitted for your approval.')
            ->line('**Department:** ' . $this->requisition->department->name)
            ->line('**Amount:** ₦' . number_format($this->requisition->amount, 2))
            ->line('**Description:** ' . $this->requisition->description)
            ->action('Review Request', url('/dashboard'))
            ->line('Thank you for keeping the treasury secure!');
    }
}
