<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class BranchNumberRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if (Request::isMethod('PUT')) {
            return [
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|in:mobile,landline,fax,hotline,whatsapp',
                'number' => 'required',
            ];
        } else {
            return [
                '*.name_ar' => 'required',
                '*.name_en' => 'required',
                '*.type' => 'required|in:mobile,landline,fax,hotline,whatsapp',
                '*.number' => 'required',
            ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            failresponse($validator->errors()->first())
        );
    }
}
