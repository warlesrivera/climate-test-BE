<?php

namespace App\Modules\User\Decorators;

use App\Models\User;
use App\Models\Headquarter;
use Illuminate\Support\Facades\Log;
use App\Modules\User\Request\UserRequest;
use App\Modules\User\Interfaces\IUserDecorator;
use App\Modules\User\Repositories\UserRepository;
use Hash;

class UserDecorator implements IUserDecorator
{
    protected $_userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    public function All()
    {
        try
        {
            $users = $this->_userRepository->All();
            return  [
                'success' => true,
                'code' => 200,
                'data' => $users
            ];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => __('validation.server.500')
                ]
            ];
        }
    }
    public function UpsertUser(UserRequest $request, User $user = null)
    {
        try
        {
            $message = __('validation.update', ['attributes' => __('validation.attributes.user')]);

            if ($user == null) {

                $user = new User($request->all());
                $user->headquarter_id = Headquarter::first()->id;
                $user->password = Hash::make($user->password);
                $message =__('validation.success', ['attributes' => __('validation.attributes.user') ]);
            }
            else
            {
                $user->fill( $request->all()) ;
            }

            $this->_userRepository->save($user);
            return  [
                'success' => true,
                'code' => 200,
                'data' =>['message' => $message]

            ];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'message' => __('validation.delete', ['attributes' => 'user'])
            ];
        }
    }
    public function Get(int $id)
    {
        try
        {
            $user = $this->_userRepository->get($id);
            return  [
                'success' => true,
                'code' => 200,
                'data' => $user
            ];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => __('validation.server.500')
                ]
            ];
        }
    }
    public function Delete(int $id)
    {
        try
        {
            $user = $this->Get($id);

            if( $this->_userRepository->delete($user['data']))
            {
                return  [
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'message' => __('validation.delete',['attributes' => __('validation.attributes.user')])
                    ]
                ];
            }
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            Log::error($e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            throw new \Exception(__('validation.server.500'));
        }
        catch (\Exception $ex)
        {
            Log::error($ex->getMessage());

            return [
                'success' => false,
                'code' => 500,
                'data' => [
                    'message' => __('validation.server.500')
                ]
            ];
        }
    }
}
