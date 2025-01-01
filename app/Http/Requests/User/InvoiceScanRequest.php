<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceScanRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => 'required_without_all:tax_number,invoice_date,total',
            'tax_number' => 'required_with_all:invoice_date,total',
            'invoice_date' => 'required_with_all:tax_number,total',
            'total' => 'required_with_all:invoice_date,tax_number',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            failresponse($validator->errors()->first())
        );
    }
}
