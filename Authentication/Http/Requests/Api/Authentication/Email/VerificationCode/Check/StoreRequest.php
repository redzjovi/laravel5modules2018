<?php

namespace Modules\Authentication\Http\Requests\Api\Authentication\Email\VerificationCode\Check;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'verification_code' => [
                'required',
                new \Modules\User\Rules\Email\VerificationCodeCheck($this->input()),
            ],
        ];
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
}
