@component('mail::message')
# hola {{ $user->name }}

Gracias por crear una cuenta. Por favor verficala usando el siguiente boton:

@component('mail::button', ['url' => route('verify', $user->verification_token ) ])
 Confirmar mi cuenta
@endcomponent

Muchas Gracias,<br>
{{ config('app.name') }}
@endcomponent

