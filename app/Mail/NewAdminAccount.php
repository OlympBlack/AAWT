<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewAdminAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $temporaryPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $temporaryPassword)
    {
        $this->user = $user;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.new-admin-account')
                    ->subject('Votre nouveau compte administrateur');
    }
}
