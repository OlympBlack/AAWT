<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;

    protected $payment;
    protected $remainingAmount;
    protected $isFullPayment;

    public function __construct($payment, $remainingAmount, $isFullPayment)
    {
        $this->payment = $payment;
        $this->remainingAmount = $remainingAmount;
        $this->isFullPayment = $isFullPayment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $studentName = optional($this->payment->registration->student)->full_name ?? 'Étudiant inconnu';
        
        if ($this->isFullPayment) {
            $message = "Vous avez payé la totalité de la scolarité de {$studentName}. Montant payé : {$this->payment->amount} FCFA.";
        } else {
            $trancheNumber = $this->payment->registration->payments()->count();
            $message = "Vous avez payé la tranche {$trancheNumber} de la scolarité de {$studentName}. Montant payé : {$this->payment->amount} FCFA. Il vous reste {$this->remainingAmount} FCFA à payer.";
        }

        return [
            'message' => $message,
            'payment_id' => $this->payment->id,
        ];
    }
}