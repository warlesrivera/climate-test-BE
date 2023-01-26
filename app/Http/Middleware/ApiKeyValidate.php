<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class ApiKeyValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $id = auth()->user()->idusuario;

        if (empty(auth()->user()->token()))
            return response()->json(array('auth' => false, 'errors' => 'El login no existe'), 200);

        if (!auth()->user()->token()->expires_at > Carbon::now())
            return response()->json(array('auth' => false, 'errors' => 'la sesion ya expiro.'), 200);

        return $next($request);
    }
}
