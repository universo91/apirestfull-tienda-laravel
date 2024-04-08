<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Laravel automaticamente inyectara en la vista los atributos que tengamos en nuestro mailable
     * por tanto no hace falta agregar o modificar el metodo build, ya que el atributo "$user" sera inyectado
     * automaticamente ne la vista emails.welcome
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        /**
         * Para crear un titulo o tema la correo electronico lo haremos por medio del metodo subject().
         */
        /* return $this->text('emails.welcome')->subject("Por favor confirma tu correo electronico"); */
        return $this->markdown('emails.welcome')->subject("Por favor confirma tu correo electronico");
    }
}
