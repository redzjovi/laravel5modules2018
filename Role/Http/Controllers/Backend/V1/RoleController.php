<?php

namespace Modules\Role\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Role\Http\Requests\Backend\V1\Role\StoreRequest;
use Modules\Role\Http\Requests\Backend\V1\Role\UpdateRequest;
use Modules\Role\Models\Role;

class RoleController extends \Modules\Cms\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        request()->query('per_page') ?: request()->query->set('per_page', '10');
        request()->query('sort') ?: request()->query->set('sort', '-updated_at');
        $parameters = request()->query();

        $data['model'] = new Role;
        $data['roles'] = Role::getRoles($parameters);

        return view('role::backend/v1/role/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Role;

        return view('role::backend/v1/role/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Role::create($request->input());
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
    public function edit(Role $role)
    {
        $data['model'] = $role;
        return view('role::backend/v1/role/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $role->fill($request->input())->save();
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
                        Role::destroy($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Role $role)
    {
        $role->delete();
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $columns[] = trans('cms::cms.name');
        $columns[] = trans('cms::cms.guard_name');
        $csv->insertOne($columns);

        $roles = Role::getRoles($request->query());
        $roles->each(function ($role) use ($csv) {
            $columns = [];
            $columns[] = $role->name;
            $columns[] = $role->guard_name;
            $csv->insertOne($columns);
        });

        $csv->output('role_'.date('Ymd_His').'.csv');
    }
}
