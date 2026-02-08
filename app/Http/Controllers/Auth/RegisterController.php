<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController
{
    public function __construct(protected CreateNewUser $createNewUser)
    {

    }

    public function __invoke(RegisterRequest $request){
        return $this->createNewUser->create($request->all());
    }

}