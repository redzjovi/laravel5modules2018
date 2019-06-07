<?php

namespace Modules\Authentication\Http\Controllers\Api\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Resources\Api\UserResource;

/**
 * @group Authentication
 */
class UserController extends Controller
{
    /**
     * user GET
     * @queryParam with[] With ie. with[]=roles
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "name": "Admin",
     *          "email": "admin@mailinator.com",
     *          "verification_code": "682042",
     *          "created_at": {
     *              "date": "2019-02-20 14:54:56.000000",
     *              "timezone_type": 3,
     *              "timezone": "Asia/Jakarta"
     *          },
     *          "updated_at": {
     *              "date": "2019-03-07 18:53:23.000000",
     *              "timezone_type": 3,
     *              "timezone": "Asia/Jakarta"
     *          }
     *      }
     *  ]
     * }
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        return new UserResource($user);
    }
}
