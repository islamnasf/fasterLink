<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteImageRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
                'id'=>'required|array',
                'type'=>'required|array|in:logo,cover,department,loyalty,profile',
                'image'=>'required|array',
            ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
          failresponse($validator->errors()->first())
        );
    }
}
