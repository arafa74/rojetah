<?php

namespace App\Http\Controllers\API\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\App\RegisterSocialAPIRequest;
use App\Models\User;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->ResponseApi($validator->errors()->first(), $validator->errors(), 422);
        }
        if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            $user = auth()->user();
            $loginMessage = trans('messages.successfully_login');
            $token = $user->createToken('rojetah')->accessToken;
            $fractal = fractal()
                ->item($user)
                ->transformWith(new UserTransformer())
                ->toArray();
            return $this->ResponseApi($loginMessage, $fractal, 200, ['token' => $token]);
        } else {
            return $this->ResponseApi(trans('messages.login_error'), null, 401);
        }
    }


    public function social_login(RegisterSocialAPIRequest $request)
    {
        $user = User::where('provider_id', $request->provider_id)->first();
        if (!$user) {
            $validator = Validator::make($request->all(), [
                'mobile' => 'nullable|unique:Users',
                'email' => 'nullable|email|min:3|max:255|unique:Users',
            ]);
            if ($validator->fails()) {
                return $this->ResponseApi($validator->errors()->first(), $validator->errors(), 422);
            }
            $requestData = $request->validated();
            if (!$request->f_name) {
                $requestData['f_name'] = 'f_guest ' . uniqid();
            }
            if (!$request->l_name) {
                $requestData['l_name'] = 'l_guest ' . uniqid();
            }
            $user = User::create($requestData);

        }else{
            $user->provider = $request->provider;
            $user->update();
        }

        $accessToken = $user->createToken('authToken')->accessToken;
        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("data added successfully", $fractal, 200);


    }
}
