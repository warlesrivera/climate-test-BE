<?php

namespace App\Modules\User\Interfaces;

use App\Models\User;
use App\Modules\User\Request\UserRequest;

interface IUserDecorator
{
    public function All();
    public function UpsertUser(UserRequest $request, User $user = null);
    public function Get(int $id);
    public function Delete(int $id);
}
