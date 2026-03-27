<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $email,
        public string $purpose,
        public ?object $siteSetting,
        public ?string $userName = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'frontend.auth.email-otp-verify-account',
            with: [
                'otp' => $this->otp,
                'purpose' => $this->purpose,
                'siteSetting' => $this->siteSetting,
                'user' => $this->userName ? (object) ['name' => $this->userName] : null,
            ],
        );
    }
}
