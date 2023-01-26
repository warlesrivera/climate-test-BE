<?php

namespace App\Modulos\Login\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContrasenaVencidaMailMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * información necesario para el envio del correo
     *
     * @var array $datos ['pin', 'nombre', 'plantilla', 'asunto']
     */
    public $datos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->datos['asunto'])
            ->view($this->datos['plantilla'])
            ->with([
                'nombre' => $this->datos['nombre'],
                'pin' => $this->datos['pin'],
            ]);
    }
}
