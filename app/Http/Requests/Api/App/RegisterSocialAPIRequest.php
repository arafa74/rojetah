<?php

namespace App\Http\Requests\Api\App;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterSocialAPIRequest extends FormRequest
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
        $rules['f_name'] = 'nullable|string';
        $rules['l_name'] = 'nullable|string';
        $rules['provider_id'] = 'required';
        $rules['provider'] = 'required|in:google,facebook,apple';
        $rules['email'] = 'nullable|email|min:3|max:255';
        $rules['mobile'] = 'nullable';
        $rules['password'] = 'nullable|max:50';
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
