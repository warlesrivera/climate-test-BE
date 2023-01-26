<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait
{

    public function issueToken(Request $request, $grantType, $scope = "")
    {

        $params = [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'scope' => $scope
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);
    }
}
