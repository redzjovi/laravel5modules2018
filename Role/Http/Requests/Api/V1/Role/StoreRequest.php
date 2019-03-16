<?php

namespace Modules\Role\Http\Requests\Api\V1\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Role\Models\Role;

class StoreRequest extends FormRequest
{
    protected $model;

    public function __construct()
    {
        $this->model = new Role;
    }

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
        return [
            'name' => [
                'required',
                Rule::unique($this->model->getTable()),
            ],
        ];
    }
}
