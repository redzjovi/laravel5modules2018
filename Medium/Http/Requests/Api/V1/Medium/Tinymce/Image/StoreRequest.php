<?php

namespace Modules\Medium\Http\Requests\Api\V1\Medium\Tinymce\Image;

use Illuminate\Contracts\Validation\Validator;
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
            'file' => ['image', 'max:5120']
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

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(
                [
                    'errors' => (new \Illuminate\Validation\ValidationException($validator))->errors(),
                    'message' => implode(' ', $validator->messages()->all())
                ],
                \Illuminate\Http\JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
