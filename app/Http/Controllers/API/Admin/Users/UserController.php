<?php

namespace App\Http\Controllers\API\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Api\Admin\Users\UserTransformer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($q) use ($request) {
            $q->where('email', $request->search)
                ->orWhere('mobile',$request->search)
                ->orWhere('f_name', 'LIKE', "%{$request->search}%")
                ->orWhere('l_name', 'LIKE', "%{$request->search}%");
        })->when($request->is_block, function ($q) use ($request) {
            $q->where('is_block', $request->is_block);
        })->when($request->mobile_verified, function ($q) use ($request) {
            $q->where('mobile_verified', $request->mobile_verified);
        });
        $count = $users->count();
        $skip = ($request->has('skip')) ? $request->skip : 0;
        if ($request->has('skip')) {
            $users = $users->skip($skip)->take(10);
        }
        $users = $users->orderBy('created_at', 'DESC')->get();
        $users = fractal()
            ->collection($users)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("", $users, 200, ['count' => $count]);
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $userData = new UserTransformer();
        $fractal = fractal()
            ->item($user)
            ->transformWith($userData)
            ->includeRoles()
            ->toArray();
        return $this->ResponseApi("", $fractal, 200);
    }
}
