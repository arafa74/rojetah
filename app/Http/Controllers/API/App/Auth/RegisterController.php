<?php

namespace App\Http\Controllers\API\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\App\RegisterRequest;
use App\Models\User;
use App\Transformers\Api\UserTransformer;

class RegisterController extends Controller
{
    public function Register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->mobile_verified = 0;
        $user->update();
        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("data added successfully", $fractal, 200);
    }
}
