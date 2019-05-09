<?php

namespace Modules\Category\Http\Requests\Api\V1\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['title_'.config('app.locale')] = ['required'];
        $rules['image.*'] = ['image'];
        $rules['gallery.*'] = ['image'];

        return $rules;
    }
}
