<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. DECLARAMOS LA VARIABLE PÚBLICA
    // Al ser pública, Laravel la hace disponible automáticamente en la vista de Blade.
    public $tickets;

    /**
     * 2. MODIFICAMOS EL CONSTRUCTOR
     * Aquí es donde recibiremos el array de tickets desde el Controlador.
     */
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * 3. MODIFICAMOS EL ASUNTO (Opcional pero recomendado)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus entradas para Zoo-logic - ¡Gracias por tu compra!',
        );
    }

    /**
     * 4. DEFINIMOS LA VISTA CORRECTA
     * Cambiamos 'view.name' por la ruta de tu archivo blade.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets', // Esto buscará en resources/views/emails/tickets.blade.php
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
