<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $temporaryPassword;
    private $pdf;

    public function __construct($student, $temporaryPassword, $pdf)
    {
        $this->student = $student;
        $this->temporaryPassword = $temporaryPassword;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Bienvenue à MySchool - Votre carte d\'identité scolaire')
            ->markdown('emails.student-welcome-with-card')
            ->attachData($this->pdf->output(), 'carte_scolaire.pdf', [
                'mime' => 'application/pdf'
            ]);
    }
}