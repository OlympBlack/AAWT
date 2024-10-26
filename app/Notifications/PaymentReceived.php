<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentReceived extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        if (!$this->payment) {
            return [
                'message' => "Un paiement a été reçu, mais les détails sont indisponibles.",
                'payment_id' => null
            ];
        }

        $studentName = "l'élève";
        if ($this->payment->registration && $this->payment->registration->student) {
            $student = $this->payment->registration->student;
            $studentName = "{$student->firstname} {$student->lastname}";
        }

        return [
            'message' => "Un paiement de {$this->payment->amount} a été reçu pour {$studentName}.",
            'payment_id' => $this->payment->id
        ];
    }
}
