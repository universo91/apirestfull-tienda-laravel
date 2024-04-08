
@component('mail::message')
# hola {{ $user->name }}

Has cambiado tu correo electronico. Por favor verifica la nueva direccion usando usando el siguiente boton:

@component('mail::button', ['url' => route('verify', $user->verification_token ) ])
 Confirmar mi cuenta
@endcomponent

Muchas Gracias,<br>
{{ config('app.name') }}
@endcomponent

