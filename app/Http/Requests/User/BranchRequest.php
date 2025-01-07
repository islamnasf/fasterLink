<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class BranchRequest extends FormRequest
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
                'name_en' => 'required',
                'name_ar' => 'required',
                'city_id' => 'required',
                'store_id' => 'required',
                'location' => 'sometimes',
                'address_en' => 'sometimes',
                'address_ar' => 'sometimes',
                'is_main' => 'sometimes',
            ];
        } else {
            return [
                'name_en' => 'required',
                'name_ar' => 'required',
                'city_id' => 'required',
                'store_id' => 'required',
                'location' => 'sometimes',
                'address_en' => 'sometimes',
                'address_ar' => 'sometimes',
                'is_main' => 'sometimes',
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
