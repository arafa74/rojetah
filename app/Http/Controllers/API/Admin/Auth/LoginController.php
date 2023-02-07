<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginRequest;
use App\Transformers\Api\Admin\UserTransformer;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    public function login(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $accessToken = auth()->guard('admin')->user()->createToken('authToken')->accessToken;
            $fractal = fractal()
                ->item(auth()->guard('admin')->user())
                ->transformWith(new UserTransformer())
                ->toArray();
            return $this->ResponseApi(trans('lang.api.retrieved'), $fractal, 200, ['token' => $accessToken]);
        }
        return $this->ResponseApi('This is wrong credentials', "", 422);
    }

}
