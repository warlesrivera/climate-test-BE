<?php

namespace App\Modules\Login\Interfaces;

use App\Modules\Login\Requests\LoginRequest;

/**
 * Interface encargada de delegar las operaciones de la entidad Auth/Login - Auth/Logout
 *
 * @method Login(LoginRequest $request)
 *
 * @author Sergio Benavides
 */
interface ILoginDecorator
{
    /**
     *
     * Funcion encargada de registrar un usuario comercio
     *
     * @param LoginRequest $request
     *
     * @return array
     *
     * @author Sergio Benavides
     */
    public function Login(LoginRequest $request): array;
}
