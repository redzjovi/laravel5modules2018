<?php

namespace Modules\Page\Http\Requests\Api\V1\Page;

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
        $rules['redirect_to'] = ['url'];
        $rules['image.*'] = ['image'];
        $rules['gallery.*'] = ['image'];

        return $rules;
    }
}
