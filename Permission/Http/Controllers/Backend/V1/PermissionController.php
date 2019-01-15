<?php

namespace Modules\Permission\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Permission\Http\Requests\Backend\V1\Permission\StoreRequest;
use Modules\Permission\Http\Requests\Backend\V1\Permission\UpdateRequest;
use Modules\Permission\Models\Permission;

class PermissionController extends \Modules\Cms\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['model'] = new Permission;
        $data['permissions'] = Permission::search(request()->query())->paginate();

        return view('permission::backend/v1/permission/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Permission;

        return view('permission::backend/v1/permission/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Permission::create($request->input());
        flash(trans('cms::cms.stored'))->important()->success();
        return redirect()->back();
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
    public function edit(Permission $permission)
    {
        $data['model'] = $permission;

        return view('permission::backend/v1/permission/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Permission $permission)
    {
        $permission->fill($request->input())->save();
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


    public function action(\Modules\Cms\Http\Requests\Backend\V1\Repository\ActionRequest $request)
    {
        if ($action = $request->action) {
            if ($action == 'actionDelete') {
                if ($ids = $request->id) {
                    foreach ($ids as $id) {
                        Permission::destroy($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(int $id)
    {
        Permission::destroy($id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $columns[] = trans('cms::cms.name');
        $columns[] = trans('cms::cms.guard_name');
        $csv->insertOne($columns);

        $permissions = Permission::search(request()->query())->get();
        $permissions->each(function ($permission) use ($csv) {
            $columns = [];
            $columns[] = $permission->name;
            $columns[] = $permission->guard_name;
            $csv->insertOne($columns);
        });

        $csv->output('permission_'.date('Ymd_His').'.csv');
    }
}
