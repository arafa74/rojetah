<?php

namespace App\Http\Requests\Api\App;

use App\Rules\MatchOldPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return
            [
            'mobile' => 'required|exists:users,mobile',
            'code' => 'required|exists:o_t_p_s,code',
            'new_password' => 'required',
            'new_confirm_password' => 'same:new_password',
            ];


    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => false,
            'message' => $validator->errors()->first(),
            'data' => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }


}
