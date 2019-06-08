<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Models\User;

/**
 * @group Authentication
 */
class ForgotController extends Controller
{
    /**
     * password/forgot POST
     * @bodyParam email email required Email Example: superadmin@mailinator.com
     * @response {
     *  "message": "Success"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "email": [
     *          "The Email field is required."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Authentication\Http\Requests\Api\Authentication\Password\Forgot\StoreRequest $request)
    {
        $user = User::findModelByField('email', $request->input('email'));
        $user = User::updateVerificationCodeById($user->id);

        $actionUrlQuery = [
            'email' => $user->email,
            'verification_code' => $user->verification_code
        ];
        $actionUrl = config('cms.backend.app.url').'/authentication/password/reset?'.http_build_query($actionUrlQuery);

        $user->notify(
            new \Modules\Authentication\Notifications\PasswordResetLink($user, $actionUrl)
        );

        return response()->json(['message' => trans('cms::cms.success')]);
    }
}
