<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BankTransferPaymentUpdatedNotification extends Notification
{
    public function __construct(public Booking $booking, public string $message) {}

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
            ->subject('Bank transfer update for '.$this->booking->order_number)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->message)
            ->line('Order: '.$this->booking->order_number)
            ->line('Amount: '.$this->booking->currency.' '.number_format((float) $this->booking->amount, 2))
            ->action('View order', route('bank-transfer.show', $this->booking));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return ['booking_id' => $this->booking->id, 'order_number' => $this->booking->order_number, 'message' => $this->message];
    }
}
