<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'question_en'=>'required',
            'answer_en'=>'required',
            'question_ar'=>'required',
            'answer_ar'=>'required',
            'app'=>'required|in:user,store',
        ];
    }

}
