<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class Verification extends Mailable
{
    use Queueable, SerializesModels;

    public $jobHash;
    public $nameView;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobHash, $nameView)
    {
        $this->jobHash = $jobHash;
        $this->nameView = $nameView;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Подтверждение почты',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'Client/Mail/verification',
            with: [
                '$jobHash' => $this->jobHash,
                '$pathname' => $this->nameView,
            ]
        );
    }
}
