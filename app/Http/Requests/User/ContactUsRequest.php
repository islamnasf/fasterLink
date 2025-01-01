<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactUsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'phone'=>'required',
            'title'=>'required',
            'message'=>'required',
            'app'=>'required|in:web,store,user',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
          failresponse($validator->errors()->first())
        );
    }
}
