<?php

namespace Modules\Permission\Http\Requests\Backend\V1\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Permission\Models\Permission;

class UpdateRequest extends FormRequest
{
    protected $model;

    public function __construct()
    {
        $this->model = new Permission;
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
                Rule::unique($this->model->getTable())->ignore(request()->route()->parameter('permission')),
            ],
        ];
    }
}
