<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'description_en'=>'required',
            'description_ar'=>'required',
            'file'=>'sometimes|nullable|file',
            'file_type'=>'required_with:file|in:image,video',
            'price'=>'required',
        ];
    }

}
