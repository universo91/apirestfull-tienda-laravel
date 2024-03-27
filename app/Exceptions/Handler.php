<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * El metodo report se refiere a la lógica de escribir los detalles del error a log y/o enviarlos
     * a servicios externos de gestioń de errores (Sentry, Bugsnag, etc).
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

   /**
    * El metodo render se encarga de la lógica responsable de mostrar un error amigable al
    * usuario final.
    */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException)
        {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if( $exception instanceof ModelNotFoundException)
        {
            $modelo = strtolower(class_basename( $exception->getModel() ) );
            return $this->errorResponse('No existe ninguna instancia de { $modelo } con el id especificado', 404);
        }

        if( $exception instanceof AuthenticationException)
        {
            return $this->unauthenticated($request, $exception);
        }

        if( $exception instanceof AuthorizationException)
        {
            return $this->errorResponse('No posee permisos para ejecutar esta accion.', 403);
        }

        /**
         * la Excepcion NotFoundHttpException significa que laravel no fue capaz de encontrar una ruta para la solicitud.
         */
        if( $exception instanceof NotFoundHttpException)
        {
            return $this->errorResponse('No se encontró la URL especificada.', 404);
        }

        /**
         * Este tipo de excepcion sirve para cuando una ruta especifica existe, pero no esta disponible
         * para el metodo HTTP correspondiente( GET, PUT, POST...).
         */
        if( $exception instanceof MethodNotAllowedHttpException ) {
            return $this->errorResponse('El metodo especificado en la peticion no es valida.', 405);
        }

        /**
         * Existen tantos tipos de excepciones http que podrian surgir durante la ejecucion de nuestro
         * programa, no es buena practica generar o establecer un mensaje para cada uno de ellos.
         * Nos enfocamos en desarrollar mensajes personalizados para los excepciones mas comunes, y para
         * el resto generaremos una excepcio generica.
         */
        if( $exception  instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if( $exception instanceof QueryException ) {

            /**
             * El codigo 1451 esta relacionada con la eliminacion de una entidad que tiene relacion con otra.
             */
            $codigo = $exception->errorInfo[1];

            if( $codigo == 1451) {
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque esta relacionado con algun otro.', 409 );
            }
        }

        if( config('app.debug') ) {
            return parent::render($request, $exception);

        }

        /**
         * Cualquier tipo de excepcion que no hayamos contemplado, seria una excepcion inesperada, algo de  tipo 500
         * Despues de todas la condiciones que tenemos, si nunguna de las posibles excepciones para las cuales estamos
         * preparados coincide, entonces vamos a suponer que es una falla inesperada.
         */
        return $this->errorResponse('Falla inesperada. Intente luego', 500);
    }



    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No autenticado.', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }
}
