<?php

namespace App\Http\Requests\Api\App;

use App\Rules\MatchOldPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChagePasswordRequest extends FormRequest
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
            'current_password' => ['required', new MatchOldPassword],
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
