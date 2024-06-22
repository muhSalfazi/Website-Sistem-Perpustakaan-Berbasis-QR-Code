<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetToken;
    public $tokenDuration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resetToken, $tokenDuration)
    {
        $this->resetToken = $resetToken;
        $this->tokenDuration = $tokenDuration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset_password')
                    ->with([
                        'resetToken' => $this->resetToken,
                        'tokenDuration' => $this->tokenDuration,
                    ]);
    }
}