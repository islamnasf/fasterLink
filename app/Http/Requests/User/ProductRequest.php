<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
                'name_ar' => 'sometimes',
                'name_en' => 'sometimes',
                'description_ar' => 'sometimes',
                'description_en' => 'sometimes',
                'basic_price' => 'sometimes',
                'price' => 'sometimes',
                'image' => 'sometimes',
                'department_id' => 'sometimes|exists:departments,id',
                'active' => 'sometimes|boolean'
            ];
        } else {
            return [
                'name_ar' => 'required',
                'name_en' => 'required',
                'description_ar' => 'required',
                'description_en' => 'required',
                'basic_price' => 'required',
                'price' => 'required',
                'image' => 'sometimes',
                'department_id' => 'required|exists:departments,id',
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
