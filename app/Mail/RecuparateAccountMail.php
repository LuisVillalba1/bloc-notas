<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class RecuparateAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $usuario;

    public function __construct($usuarioID)
    {
        $this->usuario = $usuarioID;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuparate Account Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //cremamos un link que va a ser temporal
        $LinkCancelar = URL::temporarySignedRoute(
            "changePassword",
            //agregamos que el link tenga una fehcha de expiracion de 1 hora
            now()->addHours(1),
            ["id"=>Crypt::encryptString($this->usuario)]
        );

        return new Content(
            view: 'recuperateAccount',
            with : [
                "link" => $LinkCancelar,
            ]
        );
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
