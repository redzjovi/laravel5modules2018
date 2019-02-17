<?php

namespace Modules\Page\Http\Requests\Api\V1\Page;

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
        $rules = [];

        foreach (config('cms.locales') as $locale => $localeName) {
            $rules['title_'.$locale] = ['required'];
        }

        $rules['image.*'] = ['image'];
        $rules['gallery.*'] = ['image'];

        return $rules;
    }
}
