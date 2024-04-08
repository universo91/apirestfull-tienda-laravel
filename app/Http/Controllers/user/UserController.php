<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function index()
    {
        $usuarios = User::all();

        return $this->showAll( $usuarios );
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USAUARIO_REGULAR;

        $usuario = User::create($campos);

        return $this->showOne( $usuario, 201 );
    }

    /* public function show($id)
    {
        $usuario = User::findOrFail($id);
        return $this->showOne($usuario);
    } */

    /**
     * Es importante que
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


    public function update(Request $request, User $user)
    {

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USAUARIO_REGULAR
        ];

        $this->validate($request, $rules);

        if( $request->has('name')) {
            $user->name = $request->name;
        }

        if( $request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if( $request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if( $request->has('admin')) {
            if(! $user->esVerificado() ) {
                return $this->errorResponse('Unicamente los usuarios verificados pueden camibar su valor de administrador', 409);
            }

            $user->admin = $request->admin;
        }

        if( ! $user->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /* public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();

        return $this->showOne( $user );
    } */

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne( $user );
    }

    public function verify($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();

        $user->verified = User::USUARIO_VERIFICADO;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage( 'La cuenta ha sido verificada' );
    }
}
