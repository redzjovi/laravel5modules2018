<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @group Authentication
 */
class LogoutController extends Controller
{
    /**
     * logout POST
     * @headerParam AccessToken required
     * @response {
     *  "message": "Successfully logged out"
     * }
     */
    public function store(Request $request)
    {
        auth('api')->logout();
        return response()->json(['message' => trans('cms::cms.successfully_logged_out')]);
    }
}
