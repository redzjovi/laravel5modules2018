<?php

namespace Modules\Role\Http\Controllers\Backend\V1\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Permission\Models\Permission;
use Modules\Role\Http\Requests\Api\V1\Role\Permission\UpdateRequest;
use Modules\Role\Models\Role;

class PermissionController extends \Modules\Cms\Http\Controllers\Controller
{
    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(Role $role)
    {
        $data['model'] = $role;
        $data['permissions'] = Permission::getPermissionsOrderByName();

        return view('role::backend/v1/role/permission/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $role->syncPermissions($request->input('permission_name'));
        flash(trans('cms::cms.updated'))->important()->success();
        return redirect()->back();
    }
}
