<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class StoreRequest extends FormRequest
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
                'name_en' => 'sometimes',
                'name_ar' => 'sometimes',
                'description_en' => 'sometimes',
                'description_ar' => 'sometimes',
                'logo' => 'sometimes',
                'username' => "required|unique:stores,username,".$this->id,
                'category_id' => 'sometimes|exists:categories,id',
                'city_id' => 'sometimes|exists:cities,id',
                'full_description_en' => 'sometimes',
                'full_description_ar' => 'sometimes',
                'cover_type' => 'sometimes|in:images,video',
                'cover_images' => 'sometimes',
                'cover_video_url' => 'sometimes',
            ];
        } else {
            return [
                'name_en' => 'sometimes',
                'name_ar' => 'sometimes',
                'description_en' => 'sometimes',
                'description_ar' => 'sometimes',
                'logo' => 'required',
                'username' => 'required|unique:stores,username',
                'category_id' => 'sometimes|exists:categories,id',
                'city_id' => 'sometimes|exists:cities,id',
                'full_description_en' => 'sometimes',
                'full_description_ar' => 'sometimes',
                'cover_type' => 'sometimes|in:images,video',
                'cover_images' => 'required_if:cover_type,images',
                'cover_video_url' => 'required_if:cover_type,video',
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
