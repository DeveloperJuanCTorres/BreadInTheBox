<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Cotizar extends Mailable
{
    use Queueable, SerializesModels;
    public $contacto;
    
    public function __construct($mensaje)
    {
        $this->contacto = $mensaje;
    }

    public function build()
    {
        return $this->view('emails.menssageCotizar');
    }
}
