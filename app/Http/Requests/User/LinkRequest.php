<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LinkRequest extends FormRequest
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
                'active' => 'required|boolean',
            ];
        } else {
            return [
                'name_ar' => 'required_if:link_type_id,null',
                'name_en' => 'required_if:link_type_id,null',
                'url' => 'required|url',
                'image' => 'sometimes',
                'link_type_id' => 'required|exists:link_types,id',
                'link_library_id' => 'sometimes|exists:link_libraries,id',
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
