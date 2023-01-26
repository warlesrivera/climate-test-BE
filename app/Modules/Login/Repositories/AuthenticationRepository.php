<?php

namespace App\Modules\Login\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * @author  Ubarles Rivera
 */
class AuthenticationRepository
{



    /**
     * Method  verify the User is active
     *
     * @deprecated
     *
     * @param string $user
     *
     * @return bool
     *
     * @author Ubarles Rivera
     *
     */
    public function validateUserActive(string $email): bool
    {
        return $this->getUserQuery($email)->active()->exists();
    }

    /**
     * Method que get el primer User with la search
     *
     * @param string $email
     *
     * @return mixed User|null
     *
     * @author Ubarles Rivera
     */
    public function getUser(string $email): ?User
    {
        return  $this->getUserQuery($email)->first();
    }

    /**
     * Method que go la search en la base de data
     *
     * @param string $email
     *
     * @return Builder
     *
     * @author Ubarles Rivera
     */
    private function getUserQuery(string $email): Builder
    {

        return User::where('email', $email);
    }


    /**
     * Method que update la pass the User
     *
     * @param User $user
     *
     * @return bool
     *
     * @author Ubarles Rivera
     */
    public function updatePassUser(User $user): bool
    {
        $user->createPass();
        return $user->save();
    }



    public function saveToken(User $user) : array
    {
        $tokenResult = $user->createToken('Personal access Token');
        $token = $tokenResult->token;

        $token->save();

        return [
            'accessToken' => $tokenResult->accessToken,
            'tokenType' => 'Bearer',
            'expiresAt' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
    }

}
