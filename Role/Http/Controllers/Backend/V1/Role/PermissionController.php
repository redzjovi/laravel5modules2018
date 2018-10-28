<?php

namespace Modules\Role\Http\Controllers\Backend\V1\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Permission\Repositories\PermissionRepository;
use Modules\Role\Http\Requests\Backend\V1\Role\Permission\UpdateRequest;
use Modules\Role\Repositories\RoleRepository;

class PermissionController extends \Modules\Cms\Http\Controllers\Backend\V1\RepositoryController
{
    protected $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository,
        RoleRepository $repository
    )
    {
        $this->permissionRepository = $permissionRepository;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['model'] = $this->repository->with('permissions')->find($id);
        $data['permissions'] = $this->permissionRepository->orderBy('name')->all();
        return view('role::backend/v1/role/permission/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $this->repository->sync($id, 'permissions', $request->input('permission_id'));
        flash(trans('cms::cms.updated'))->important()->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        //
    }
}
