<?php

namespace Modules\Role\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Role\Http\Resources\Api\V1\RoleResource;
use Modules\Role\Models\Role;

/**
 * @group Role
 */
class RoleController extends Controller
{
    /**
     * Index
     * @queryParam id Id (number)
     * @queryParam name Name
     * @queryParam sort Sort ie. sort=name,-name
     * @queryParam with[] With ie. with[]=permissions
     * @queryParam per_page Per page (number)
     * @queryParam id Id
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "name": "Super Admin",
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
        $Roles = Role::getRoles($parameters);

        return RoleResource::collection($Roles);
    }

    /**
     * Store
     * @bodyParam name text required Name
     * @response {
     *  "data": {
     *      "id": 2,
     *      "name": "Role2",
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
    public function store(\Modules\Role\Http\Requests\Api\V1\Role\StoreRequest $request)
    {
        $role = Role::create($request->input());
        return new RoleResource($role);
    }

    /**
     * Show
     * {role} number required Id
     * @queryParam with[] With ie. with[]=permissions
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "Super Admin",
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
    public function show(Role $Role)
    {
        return new RoleResource($Role);
    }

    /**
     * Update
     * {role} number required Id
     * @queryParam with[] With ie. with[]=permissions
     * @bodyParam name text required Name
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "Super Admin",
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
    public function update(\Modules\Role\Http\Requests\Api\V1\Role\UpdateRequest $request, Role $role)
    {
        $role->fill($request->input())->save();
        return new RoleResource($role);
    }

    /**
     * Destroy
     * {role} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Role $role)
    {
        $data['count'] = Role::destroy($role->id);
        return response()->json($data);
    }
}
