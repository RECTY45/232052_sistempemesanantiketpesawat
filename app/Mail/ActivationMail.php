<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Buat instance baru dari pesan email.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Set subject email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aktivasi Akun Kamu',
        );
    }

    /**
     * Tentukan view yang digunakan dan data yang dikirim ke view
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.activation', // ini file: resources/views/emails/activation.blade.php
            with: [
                'user' => $this->user,
            ],
        );
    }

    /**
     * Attachment (jika ada)
     */
    public function attachments(): array
    {
        return [];
    }
}
