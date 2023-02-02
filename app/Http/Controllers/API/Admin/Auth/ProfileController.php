<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminUpdateProfileRequest;
use App\Transformers\Api\Admin\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        $admin = Auth::guard('admin-api')->user();
        $fractal = fractal()
            ->item($admin)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi(trans('lang.api.retrieved'), $fractal);
    }


    public function updateProfile(AdminUpdateProfileRequest $request)
    {
        $admin = auth()->guard('admin-api')->user();
        $adminData = [
            'name' => $request->name ?? $admin->name,
            'email' => $request->email ?? $admin->email,
            'password' => ($request->has('password')) ? $request->password : $admin->password,
        ];
        $admin->update($adminData);
        $adminData = fractal()
            ->item($admin)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi(trans('lang.api.updated_successfully'), $adminData, 200);
    }
}
