<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoEntregaMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $nombreVoluntario;
    public string $nombreComercio;
    public string $direccionComercio;
    public string $horarioComercio;
    public string $tituloDonacion;
    public string $codigo;

    public function __construct(
        string $nombreVoluntario,
        string $nombreComercio,
        string $direccionComercio,
        string $horarioComercio,
        string $tituloDonacion,
        string $codigo
    ) {
        $this->nombreVoluntario  = $nombreVoluntario;
        $this->nombreComercio    = $nombreComercio;
        $this->direccionComercio = $direccionComercio;
        $this->horarioComercio   = $horarioComercio;
        $this->tituloDonacion    = $tituloDonacion;
        $this->codigo            = $codigo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu código de recogida — FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.codigo_entrega',
        );
    }
}
