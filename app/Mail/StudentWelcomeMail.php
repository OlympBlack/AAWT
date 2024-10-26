<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class StudentWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $temporaryPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(User $student, $temporaryPassword)
    {
        $this->student = $student;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.student-welcome')
                    ->subject('Bienvenue sur notre plateforme scolaire');
    }
}
