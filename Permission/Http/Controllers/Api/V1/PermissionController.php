<?php

namespace Modules\Permission\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Permission\Http\Resources\Api\V1\PermissionResource;
use Modules\Permission\Models\Permission;

/**
 * @group Permission
 */
class PermissionController extends Controller
{
    /**
     * Index
     * @queryParam id Id (number)
     * @queryParam name Name
     * @queryParam sort Sort ie. sort=name,-name
     * @queryParam per_page Per page (number)
     * @queryParam id Id
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "name": "api.v1.user.*",
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
        $permissions = Permission::getPermissionsByParameters($parameters);

        return PermissionResource::collection($permissions);
    }

    /**
     * Store
     * @bodyParam name text required Name
     * @response {
     *  "data": {
     *      "id": 2,
     *      "name": "Permission2",
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
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Permission\Http\Requests\Api\V1\Permission\StoreRequest $request)
    {
        $permission = Permission::createModel($request->input());
        return new PermissionResource($permission);
    }

    /**
     * Show
     * {permission} number required Id
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "api.v1.user.*",
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
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Update
     * {permission} number required Id
     * @bodyParam name text required Name
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "api.v1.user.*",
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
     *  }
     * }
     */
    public function update(\Modules\Permission\Http\Requests\Api\V1\Permission\UpdateRequest $request, Permission $permission)
    {
        $permission = Permission::updateModelById($request->input(), $permission->id);
        return new PermissionResource($permission);
    }

    /**
     * Destroy
     * {permission} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Permission $permission)
    {
        $data['count'] = Permission::deleteModel($permission->id);
        return response()->json($data);
    }
}
