<?php

namespace Modules\User\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Resources\Api\V1\UserResource;
use Modules\User\Models\User;

/**
 * @group User
 */
class UserController extends Controller
{
    /**
     * Index
     * @queryParam id Id (number)
     * @queryParam name Name
     * @queryParam email Email
     * @queryParam role_id roles.id (number)
     * @queryParam sort Sort ie. sort=name,-name,email,-email
     * @queryParam with[] With ie. with[]=roles
     * @queryParam per_page Per page (number)
     * @queryParam id Id
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
        $parameters = $request->query();
        $users = User::getUsers($parameters);

        return UserResource::collection($users);
    }

    /**
     * Store
     * @queryParam with[] With ie. with[]=roles
     * @bodyParam name text required Name
     * @bodyParam email email required Email
     * @bodyParam password password required Password
     * @bodyParam role_name text Role name ie. "Admin"
     * @response {
     *  "data": {
     *      "id": 4,
     *      "name": "User3",
     *      "email": "user3@mailinator.com",
     *      "verification_code": null,
     *      "created_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "name": [
     *          "The Name field is required."
     *      ],
     *      "email": [
     *          "The Email field is required."
     *      ],
     *      "password": [
     *          "The Password field is required."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\User\Http\Requests\Api\V1\User\StoreRequest $request)
    {
        $user = User::createUser($request->all());
        return new UserResource($user);
    }

    /**
     * Show
     * {user} number required Id
     * @queryParam with[] With ie. with[]=roles
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "Admin",
     *      "email": "admin@mailinator.com",
     *      "verification_code": "682042",
     *      "created_at": {
     *          "date": "2019-02-20 14:54:56.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-07 18:53:23.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update
     * {user} number required Id
     * @queryParam with[] With ie. with[]=roles
     * @bodyParam name text required Name
     * @bodyParam email email required Email
     * @bodyParam password password Password
     * @bodyParam role_name text Role name ie. "Admin"
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "Admin",
     *      "email": "admin@mailinator.com",
     *      "verification_code": "682042",
     *      "created_at": {
     *          "date": "2019-02-20 14:54:56.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-07 18:53:23.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "name": [
     *          "The Name field is required."
     *      ],
     *      "email": [
     *          "The Email field is required."
     *      ]
     *  }
     * }
     */
    public function update(\Modules\User\Http\Requests\Api\V1\User\UpdateRequest $request, User $user)
    {
        $user = User::updateUserById($request->all(), $user->id);
        return new UserResource($user);
    }

    /**
     * Destroy
     * {user} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(User $user)
    {
        $data['count'] = User::deleteModel($user->id);
        return response()->json($data);
    }
}
