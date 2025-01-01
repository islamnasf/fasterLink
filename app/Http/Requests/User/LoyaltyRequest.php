<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoyaltyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'store_id' => 'required',
            'loyalty_enabled' => 'required|boolean',
            'loyalty_type' => 'required|in:invoice,product',
            
            'loyalty_invoice_amount' => 'required_if:loyalty_type,invoice|numeric',
            'loyalty_period' => 'required|numeric',

            'loyalty_product_name' => 'required_if:loyalty_type,product',
            'loyalty_product_points' => 'required_if:loyalty_type,product|numeric',
            'loyalty_product_codes' => 'required_if:loyalty_type,product|numeric',
            'loyalty_product_points_in_code' => 'required_if:loyalty_type,product|numeric',
            'only_from_my_store' => 'required_if:loyalty_type,product|boolean',

            'reward_type' => 'required|numeric|in:1,2',
            'reward_name' => 'sometimes|nullable|string',
            'reward_points' => 'sometimes|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            failresponse($validator->errors()->first())
        );
    }
}
