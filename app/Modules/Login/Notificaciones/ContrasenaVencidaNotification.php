<?php

namespace App\Modulos\Login\Notificaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modulos\Login\Mail\ContrasenaVencidaMailMessage;

/**
 * Clase ContrasenaVencidaNotification encargada de hacer el envio de la notificación
 *
 * @author Sergio Benavides
 */
class ContrasenaVencidaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Pin que se esta notificando.
     *
     * @var string $pin
     */
    public string $pin;

    /**
     * Asunto del correo de pin.
     *
     * @var string $subject
     */
    public string $asunto = "Contraseña vencida, por favor actualizarla";

    /**
     * Plantilla de correo de pin.
     *
     * @var string $plantilla
     */
    public string $plantilla = "emails.plantillas.contrasena_vencida";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $pin)
    {
        $this->pin = $pin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \App\Modulos\Pin\Mail\PinMailMessage;
     */
    public function toMail($notifiable)
    {
        return (new ContrasenaVencidaMailMessage([
            'nombre' => $notifiable->nombreComercio(),
            'pin' => $this->pin,
            'plantilla' => $this->plantilla,
            'asunto' => $this->asunto
        ]))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
