<?php

namespace Modules\Role\Http\Controllers\Api\V1\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Role\Http\Resources\Api\V1\RoleResource;
use Modules\Role\Models\Role;

/**
 * @group Role
 */
class PermissionController extends Controller
{
    /**
     * Permission Update
     * {role} number required Id
     * @queryParam with[] With ie. with[]=permissions
     * @bodyParam permission_name[] text required Permission name
     * @response {
     *  "data": {
     *      "id": 1,
     *      "name": "Super Admin",
     *      "permissions": [
     *          {
     *              "id": 1,
     *              "name": "api.user.*",
     *              "created_at": "2019-03-17 11:01:24",
     *              "updated_at": "2019-03-17 11:01:24",
     *              "pivot": {
     *                  "role_id": 1,
     *                  "permission_id": 5
     *              }
     *          }
     *      ],
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
    public function update(\Modules\Role\Http\Requests\Api\V1\Role\Permission\UpdateRequest $request, Role $role)
    {
        $role->syncPermissions($request->input('permission_name'));
        return new RoleResource($role);
    }
}
