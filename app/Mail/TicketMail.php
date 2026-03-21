<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    // Esta variable contendrá el array con 'id', 'date', 'day_used' y 'price'
    public $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus entradas para Zoo-logic - ¡Gracias por tu compra!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets', // Esta es la vista que verá el usuario en el cuerpo del email
        );
    }

    public function attachments(): array
    {
        // Generamos el PDF usando la misma vista (o podrías crear una específica para el PDF)
        // Pasamos el array de tickets para que DomPDF tenga acceso a 'day_used'
        $pdf = Pdf::loadView('emails.tickets', ['tickets' => $this->tickets]);

        return [
            Attachment::fromData(fn() => $pdf->output(), 'Entradas_ZooPark.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
