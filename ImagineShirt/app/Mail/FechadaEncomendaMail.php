<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FechadaEncomendaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($encomenda)
    {
        $this->encomenda = $encomenda;
    }

    /**
     * Construir mensagem.
     *
     * @return $this
     */
    public function build()
    {
    $pdfPath = storage_path('app/' . $this->encomenda->receipt_url);

    return $this->subject('Encomenda fechada')
                ->view('email.fechadaEncomenda', [
                    'encomenda' => $this->encomenda,
                ])
                ->attach($pdfPath, [
                    'as' => 'encomenda.pdf',
                    'mime' => 'application/pdf',
                ]);
    }

    /**
     * Buscar atachments.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}