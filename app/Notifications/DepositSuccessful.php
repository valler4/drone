<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepositSuccessful extends Notification
{
    use Queueable;

    public $amount, $paymentId;

    public function __construct($amount, $paymentId)
    {
        $this->amount = $amount;
        $this->id = $paymentId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تم شحن رصيدك بنجاح! 🚀')
            ->greeting('أهلاً ' . $notifiable->name)
            ->line('تمت عملية الإيداع بنجاح في حسابك.')
            ->line('المبلغ المضاف: ' . $this->amount . '$')
            ->line('معرف الشراء' . $this->id . '')
            ->action('عرض الرصيد', url('/dashboard'))
            ->line('شكراً لاستخدامك منصتنا لغزو القمر!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'amount' => $this->amount,
            'message' => 'تم شحن رصيدك بمبلغ ' . $this->amount . '$ بنجاح.',
        ];
    }
}
