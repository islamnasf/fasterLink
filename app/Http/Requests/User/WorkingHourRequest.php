<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class WorkingHourRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.day' => 'sometimes|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            '*.is_working' => 'sometimes|boolean',
            '*.periods' => 'nullable|array',
            '*.periods.*.open_time' => 'nullable|date_format:H:i:s',
            '*.periods.*.close_time' => 'nullable|date_format:H:i:s|after:.*.periods.*.open_time',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            failresponse($validator->errors()->first())
        );
    }
}
