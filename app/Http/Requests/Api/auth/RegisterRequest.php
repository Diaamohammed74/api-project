<?php

namespace App\Http\Requests\Api\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string','min:3','max:190'],
            'email'=>['required','email'],
            'phone'=>['required','string','max:20'],
            'password'=>['required','string','max:20','confirmed'],
        ];
    }
    public function attributes(){
        return [
            'name'=>'Name',
            'email'=>'Email',
            'phone'=>'Phone Number',
            'password'=>'Password',
            'password_confirmation' => 'Confirmation Password',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $data=$validator->messages()->all();
        $response =sendResponse($data,"Validation Error",422 );
        throw new ValidationException($validator, $response);
    }

}