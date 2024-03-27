<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    //Implementamos el trait SoftDeletes
    use Notifiable, SoftDeletes;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USAUARIO_REGULAR = 'false';

    protected $table = 'users';

    /** vamos a indicarle que el atriburo deleted_at debe ser tratado como una fecha */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //Mutador que cambia el nombre a minuscula
    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower( $valor );
    }

    //Accesor
    public function getNameAttribute($valor)
    {
        return ucwords( $valor );
    }

    //Mutador que cambia el email a minuscula
    public function stEmailAttribute( $valor )
    {
        $this->attributes['email'] = strtolower( $valor );
    }

    public function esVerificado() {
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function esAdministrador() {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificationToken()
    {
        return Str::random(40);
    }
}
