<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
class emailActivationRequest extends FormRequest
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
            'code_type' => 'required|in:email,phone',
            'code' => 'required|integer',
        ];
    }
    public function attributes(){
        return [
            'code_type'=>'Code Type',
            'code'=>'Activation Code',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $data=$validator->messages()->all();
        $response =sendResponse($data,"Validation Error",422 );
        throw new ValidationException($validator, $response);
    }
}
