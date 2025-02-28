<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KeyProductMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $keyCode;
    protected $games;
    protected $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($keyCode, $games, $amount)
    {
        $this->keyCode = $keyCode;
        $this->games = $games;
        $this->amount = $amount;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Покупка на сайте Сторегамес.рф',
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
            view: 'Client/Mail/Purchase',
            with: [
                'keyCode' => $this->keyCode,
                'games' => $this->games,
                'amount' => $this->amount,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
