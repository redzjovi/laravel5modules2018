<?php

namespace Modules\Menu\Http\Requests\Api\V1\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
