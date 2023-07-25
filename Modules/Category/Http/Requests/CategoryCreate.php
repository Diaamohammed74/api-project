<?php

namespace Modules\Category\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CategoryCreate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string','max:191'],
            'description'=>['required','string','max:200'],
        ];
    }

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
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $data=$validator->messages()->all();
        $response = ApiResponse::sendResponse($data,"Validation Error",422 );
        throw new ValidationException($validator, $response);
    }

    public function attributes(){
        return[
            'name'=>'Name',
            'description'=>'Description',
        ];
    }
}
