<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Models\User;

/**
 * @group Authentication
 */
class ResetController extends Controller
{
    /**
     * password/reset PUT
     * @bodyParam email email required Email Example: superadmin@mailinator.com
     * @bodyParam password password required Password Example: superadmin@mailinator.com
     * @bodyParam password_confirmation password required Password Confirmation Example: superadmin@mailinator.com
     * @bodyParam verification_code number required Verification Code Example: 123456
     * @response {
     *  "message": "Success"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "email": [
     *          "The Email field is required."
     *      ],
     *      "password": [
     *          "The Password field is required."
     *      ],
     *      "password_confirmation": [
     *          "The Password Confirmation field is required."
     *      ],
     *      "verification_code": [
     *          "The Verification Code field is required."
     *      ]
     *  }
     * }
     */
    public function update(\Modules\Authentication\Http\Requests\Api\Authentication\Password\Reset\UpdateRequest $request)
    {
        $user = User::getUserByEmailAndVerificationCode(
            $request->input('email'),
            $request->input('verification_code')
        );

        if ($user) {
            User::updatePasswordAndVerificationCodeById(
                $request->input('password'),
                $user->id
            );
            return response()->json(['message' => trans('cms::cms.success')]);
        }
    }
}
