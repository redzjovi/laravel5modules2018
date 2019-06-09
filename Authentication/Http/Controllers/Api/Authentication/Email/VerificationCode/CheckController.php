<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication\Email\VerificationCode;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @group Authentication
 */
class CheckController extends Controller
{
    /**
     * email/verification-code/check POST
     * @bodyParam email email required Email Example: superadmin@mailinator.com
     * @bodyParam verification_code text required Verification Code Example: 123456
     * @response 204
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "email": [
     *          "The Email field is required.",
     *          "The Email must be a valid email address.",
     *          "The selected Email is invalid."
     *      ],
     *      "verification_code": [
     *          "The Verification Code field is required.",
     *          "Verification code is invalid."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Authentication\Http\Requests\Api\Authentication\Email\VerificationCode\Check\StoreRequest $request)
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
