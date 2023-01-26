<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Modules\User\Request\UserRequest;
use App\Modules\User\Interfaces\IUserDecorator;

class UserController extends ApiController
{
    protected $_userDecorator;


    public function __construct(IUserDecorator $userDecorator)
    {
        $this->_userDecorator = $userDecorator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->_userDecorator->All();

        return  $data['success']
            ? $this->showAll($data['data'],$data['code'])
            : $this->errorResponse($data['data']['message'], $data['code']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $this->_userDecorator->UpsertUser($request);

        return  $data['success']
        ? $this->successResponse($data['data'], $data['code'])
        : $this->errorResponse($data['data']['message'], $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->_userDecorator->get($id);

        return  $data['success']
        ? $this->showOne($data['data'], $data['code'])
        : $this->errorResponse($data['data']['message'], $data['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $this->_userDecorator->UpsertUser($request, $user);

        return  $data['success']
        ? $this->successResponse($data['data'], $data['code'])
        : $this->errorResponse($data['data']['message'], $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = $this->_userDecorator->delete($id);
        return  $data['success']
        ? $this->successResponse($data['data'], $data['code'])
        : $this->errorResponse($data['data']['message'], $data['code']);
    }
}
