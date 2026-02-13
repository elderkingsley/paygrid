<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequisitionDisbursed extends Notification
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
            ->subject('Funds Released: ₦' . number_format($this->requisition->amount, 2))
            ->greeting('Good news, ' . $notifiable->name . '!')
            ->line('Your fund request for **' . $this->requisition->description . '** has been approved and disbursed.')
            ->line('**Amount:** ₦' . number_format($this->requisition->amount, 2))
            ->line('**Department:** ' . $this->requisition->department->name)
            ->line('The funds have been deducted from the treasury and are now available for use.')
            ->action('View Details', url('/dashboard'))
            ->line('Please ensure all receipts are uploaded for post-spending reconciliation.');
    }
}
