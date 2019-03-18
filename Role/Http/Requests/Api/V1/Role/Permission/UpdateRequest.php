<?php

namespace Modules\Role\Http\Requests\Api\V1\Role\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Permission\Models\Permission;

class UpdateRequest extends FormRequest
{
    protected $permission;

    public function __construct()
    {
        $this->permission = new Permission;
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
            'permission_name.*' => [
                'exists:'.$this->permission->getTable().',name',
            ],
        ];
    }
}
