<?php

namespace App\Http\Requests\Api\App;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PhoneVerifyRequest extends FormRequest
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


        $rules = [];
        $rules['code'] = 'required|exists:o_t_p_s,code';
        $rules['mobile'] = 'required|exists:users,mobile';
        $rules['usage'] = 'required|in:verify,forget_password';
        return $rules;


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
