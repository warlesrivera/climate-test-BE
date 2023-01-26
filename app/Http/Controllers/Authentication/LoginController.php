<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Modules\Login\Requests\LoginRequest;
use App\Modules\Login\Interfaces\ILoginDecorator;


/**
 * Clas LoginController encargada de delegar las funciones para auteticar un usuario o para serrar una sesion
 *
 * @method Login(LoginRequest $request)
 *
 * @author Sergio Benavides
 */
class LoginController extends ApiController
{
    /**
     * @var $ILoginDecorator
     */
    protected $ILoginDecorator;

    /**
     * Constructor de la clase
     *
     * @param ILoginDecorator $ILoginDecorator
     *
     * @author Sergio Benavides
     */
    public function __construct(ILoginDecorator $ILoginDecorator)
    {
        $this->ILoginDecorator = $ILoginDecorator;
    }

    /**
     * Metodo encargado de autenticar un usuario
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Sergio Benavides
     */
    public function Login(LoginRequest $request): JsonResponse
    {
        $loginResponse = $this->ILoginDecorator->Login($request);

        return  $loginResponse['success']
            ? $this->successResponse([
                'data' => $loginResponse['data'],
            ], $loginResponse['code'])
            : $this->errorResponse($loginResponse['data']['message'], $loginResponse['code'], $loginResponse['data']['payload']);
    }
}
