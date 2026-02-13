<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequisitionRejected extends Notification
{
    use Queueable;

    public $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update: Fund Request for ₦' . number_format($this->requisition->amount, 2))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your fund request for **' . $this->requisition->description . '** has been declined.')
            ->line('**Amount:** ₦' . number_format($this->requisition->amount, 2))
            ->line('**Department:** ' . $this->requisition->department->name)
            ->line('The reserved funds have been returned to your department\'s available budget.')
            ->action('View Dashboard', url('/dashboard'))
            ->line('If you have questions regarding this decision, please contact your department manager.');
    }
}
