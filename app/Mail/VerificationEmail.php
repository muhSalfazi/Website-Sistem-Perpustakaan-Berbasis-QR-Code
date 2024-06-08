<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->verificationUrl = route('verification.verify', $user->verification_token); // Mengganti 'verification.verify' dengan nama route yang Anda tentukan untuk proses verifikasi
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification')->view('emails.verification'); // Ganti 'emails.verification' dengan nama tampilan email verifikasi Anda
    }
}