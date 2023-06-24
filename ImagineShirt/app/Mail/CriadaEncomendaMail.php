<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CriadaEncomendaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($encomenda)
    {
        $this->encomenda = $encomenda;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
{
    return $this->view('email.confirmarEncomenda')
        ->subject('Recibo Encomenda Mail')
        ->with([
            'encomenda' => $this->encomenda,
        ]);
}


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}