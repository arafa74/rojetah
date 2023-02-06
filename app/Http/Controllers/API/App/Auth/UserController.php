<?php

namespace App\Http\Controllers\API\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\App\ChagePasswordRequest;
use App\Http\Requests\Api\App\GetOtpRequest;
use App\Http\Requests\Api\App\PhoneVerifyRequest;
use App\Http\Requests\Api\App\ResetPasswordRequest;
use App\Models\OTP;
use App\Models\User;
use App\Transformers\Api\UserTransformer;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Profile Doctor
     */
    public function profile()
    {
        $user = auth()->user();
        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("data added successfully", $fractal, 200);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * change password
     */
    public function changePassword(ChagePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = $request->new_password;
        $user->update();
        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("password Updated successfully", $fractal, 200);
    }

    public function getOtpCode(GetOtpRequest $request)
    {
        $user = User::where('mobile' , $request->mobile)->first();
        $count_of_otp_codes = $user->optCodes()->where('usage', $request->usage)->whereDate('created_at', Carbon::today())->count();
        if ($count_of_otp_codes >= 5) {
            return $this->ResponseApi(trans('messages.max_num_of_otp_codes', ['count' => 5]), null, 422);
        }

        $code = 1234; // mt_rand(1000, 9999)
        $otp = OTP::create([
            'code' => $code,
            'type' => 'phone',
            'user_id' => $user->id,
            'usage' => $request->usage
        ]);
        // SEND OTP VIA SMS PROVIDER  --- TO DO
        $reset_code_msg = trans('messages.send_code_msg_verify', ['code' => $code], $user->language);
        return $this->ResponseApi(trans('messages.reset_code_msg_sent'), null, 200);
    }

    public function verifyPhone(PhoneVerifyRequest $request)
    {
        $user = User::where('mobile' , $request->mobile)->first();
        $otp = OTP::where('user_id' , $user->id)->where('usage' , $request->usage)->where('is_used' , 0)->orderBy('id' , 'DESC')->first();
        if(!$otp){
            return $this->ResponseApi('Invalid OTP code', null, 422);
        }
        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        if ($request->usage == 'verify'){
            $user->mobile_verified = 1;
            $user->update();
            $otp->is_used = 1;
            $otp->update();
            $token = $user->createToken('rojetah')->accessToken;
            return $this->ResponseApi("phone verified successfully", $fractal, 200, ['token' => $token]);
        }else{
            return $this->ResponseApi("phone verified successfully", $fractal, 200);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('mobile' , $request->mobile)->first();
        $otp = OTP::where('user_id' , $user->id)->where('usage' , 'forget_password')->where('is_used' , 0)->orderBy('id' , 'DESC')->first();
        if(!$otp){
            return $this->ResponseApi('Invalid OTP code', null, 422);
        }
        $user->password = $request->new_password;
        $user->update();

        $otp->is_used = 1;
        $otp->update();

        $fractal = fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
        return $this->ResponseApi("password Updated successfully", $fractal, 200);
    }
}
