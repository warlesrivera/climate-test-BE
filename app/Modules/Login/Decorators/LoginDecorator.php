<?php

namespace App\Modules\Login\Decorators;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Modules\Login\Requests\LoginRequest;
use App\Modules\Login\Interfaces\ILoginDecorator;
use App\Modules\Login\Repositories\AuthenticationRepository;

/**
 *
 * @method Login(LoginRequest $request)
 * @method setUser(User $user)
 *
 * @author  Ubarles Rivera
 */
class LoginDecorator implements ILoginDecorator
{
    /**
     * @var AuthenticationRepository $dataRepository
     */
    protected $dataRepository;

    /**
     * @var User|null $user
     */
    private ?User $user = null;

    /**
     * Constructor the class
     *
     * @param AuthenticationRepository $dataRepository
     *
     * @author Ubarles Rivera
     */
    public function __construct(AuthenticationRepository $dataRepository)
    {
        $this->dataRepository = $dataRepository;
    }

    /**
     * Method para set  user
     *
     * @param User $user
     *
     * @return void
     *
     * @author Ubarles Rivera
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Method delegate the  operation the class login
     *
     * @param LoginRequest $request
     *
     * @return array
     *
     * @author Ubarles Rivera
     */
    public function Login(LoginRequest $request): array
    {
        /* try { */
            $isSuccess = $this->validateLogin($request->only('user', 'pass'));
            return $isSuccess['success']
                ?  $this->authentication($request->only('user', 'pass'))
                : [
                    'success' => false,
                    'code' => 400,
                    'data' => [
                        'message' => $isSuccess['message'],
                        'payload' => $isSuccess['payload']
                    ]
                ];
        /* } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => $e->getMessage(),
                    'payload' => ['errorKey' => 'InternalError']
                ]
            ];
        } */
    }

    private function validateLogin(array $credentials): array
    {
        $this->user = $this->dataRepository->getUser($credentials['user']);

        return Auth::validate(['email' => $credentials['user'], 'password' => $credentials['pass']])
            ? [
                'success' => true,
                'message' => "login exitoso",
                'payload' => []
            ]
            : [
                'success' => false,
                'message' => __('validation.auth.noExiste'),
                'payload' => [
                    'errorKey' => 'noExiste'
                ]
            ];
    }

    /**
     * Método encargado de autenticar al usuario y generar el token de autenticacion
     *
     * @param array $data
     *
     * @return array
     *
     * @author Ubarles Rivera
     */
    private function authentication(): array
    {
        Auth::login($this->user);

        return [
            'success' => true,
            'code' => 200,
            'data' => [
                'token' => $this->dataRepository->saveToken($this->user),
                'user' =>auth()->user(),
                'message' => __('validation.auth.login')
            ]
        ];
    }
}
