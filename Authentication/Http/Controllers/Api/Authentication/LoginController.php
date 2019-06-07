<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @group Authentication
 */
class LoginController extends Controller
{
    /**
     * login POST
     * @bodyParam email email required Email Example: superadmin@mailinator.com
     * @bodyParam password password required Password Example: superadmin@mailinator.com
     * @response {
     *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsNXNrZWxldG9uMjAxOC5kb2NrZXJcL2FwaVwvdjFcL2F1dGhlbnRpY2F0aW9uXC9sb2dpbiIsImlhdCI6MTU1MjI3MDg3MywiZXhwIjoxNTUyMjc0NDczLCJuYmYiOjE1NTIyNzA4NzMsImp0aSI6IkZwWEtvVkhYUmhUWktWcEYiLCJzdWIiOjIsInBydiI6ImJiNjVkOWI4ZmJmMGRhOTgyN2M4ZWQyMzFkOWM1NGM4MTdmMGZiYjIifQ.wxMbMUeSR7BJkG45HbrWz0cLPUnDvx-rOOOja7NcUaw",
     *  "token_type": "bearer",
     *  "expires_in": "3600"
     * }
     * @response 401 {
     *  "message": "These credentials do not match our records."
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "email": [
     *          "The Email field is required."
     *      ],
     *      "password": [
     *          "The Password field is required."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Authentication\Http\Requests\Api\Authentication\Login\StoreRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(
                ['message' => trans('auth.failed')],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
