<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPaymentNotification extends Notification
{
    use Queueable;

    protected $payment;
    protected $remainingAmount;

    public function __construct($payment, $remainingAmount)
    {
        $this->payment = $payment;
        $this->remainingAmount = $remainingAmount;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $studentName = optional($this->payment->registration->student)->full_name ?? 'Étudiant inconnu';
        $parentName = optional($this->payment->registration->parent)->full_name ?? 'Parent inconnu';

        return (new MailMessage)
                    ->line("Un nouveau paiement a été effectué.")
                    ->line("Élève : {$studentName}")
                    ->line("Parent : {$parentName}")
                    ->line("Montant payé : {$this->payment->amount} FCFA")
                    ->line("Montant restant : {$this->remainingAmount} FCFA");
    }

    public function toArray($notifiable)
    {
        $studentName = optional($this->payment->registration->student)->full_name ?? 'Étudiant inconnu';
        $parentName = optional($this->payment->registration->parent)->full_name ?? 'Parent inconnu';

        return [
            'message' => "Nouveau paiement de {$this->payment->amount} FCFA pour l'élève {$studentName} par {$parentName}. Montant restant : {$this->remainingAmount} FCFA.",
            'payment_id' => $this->payment->id,
        ];
    }
}