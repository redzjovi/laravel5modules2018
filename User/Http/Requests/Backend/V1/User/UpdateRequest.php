<?php

namespace Modules\User\Http\Requests\Backend\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Models\User;

class UpdateRequest extends FormRequest
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
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
            'name' => ['required'],
            'email' => [
                'required', 'email',
                Rule::unique($this->model->getTable())->ignore(request()->route()->parameter('user')),
            ],
        ];
    }
}
