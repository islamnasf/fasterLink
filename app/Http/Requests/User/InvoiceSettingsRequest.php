<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceSettingsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
                'store_id'=>'required',
                'is_electronic_invoice'=>'required|boolean',
                'is_invoice_coding'=>'required|boolean',
                'is_invoice_has_code'=>'required|boolean',
                'coding_type'=>'required|in:excel,invoice,points',
                'tax_number'=>'required_if:is_electronic_invoice,1|unique:stores,tax_number,'.$this->store_id,
            ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
          failresponse($validator->errors()->first())
        );
    }
}
