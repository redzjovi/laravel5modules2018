<?php

namespace Modules\Authentication\Http\Requests\Backend\V1\Authentication\Password\Reset;

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
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'verification_code' => ['required'],
        ];
    }
}
