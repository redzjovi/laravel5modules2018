<?php

namespace Modules\User\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Role\Models\Role;
use Modules\User\Http\Requests\Api\V1\User\StoreRequest;
use Modules\User\Http\Requests\Api\V1\User\UpdateRequest;
use Modules\User\Models\User;

class UserController extends \Modules\Cms\Http\Controllers\Controller
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
        $parameters['with'] = ['roles'];

        $data['model'] = new User;
        $data['roles'] = Role::getRolesOrderByName();
        $data['users'] = User::getUsers($parameters);

        return view('user::backend/v1/user/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new User;
        $data['roles'] = Role::getRolesOrderByName();

        return view('user::backend/v1/user/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        User::createUser($request->all());
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
    public function edit(User $user)
    {
        $data['model'] = $user;
        $data['roles'] = Role::getRolesOrderByName();

        return view('user::backend/v1/user/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        User::updateUserById($request->all(), $user->id);
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
                        User::deleteUserById($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(User $user)
    {
        User::deleteUserById($user->id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $columns[] = trans('cms::cms.name');
        $columns[] = trans('cms::cms.email');
        if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
            $columns[] = trans('cms::cms.roles');
        }
        $csv->insertOne($columns);

        $users = User::getUsers($request->query());
        $users->each(function ($user) use ($csv) {
            $columns = [];
            $columns[] = $user->name;
            $columns[] = $user->email;
            if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
                $columns[] = $user->roles->pluck('name')->implode(',');
            }
            $csv->insertOne($columns);
        });

        $csv->output('user_'.date('Ymd_His').'.csv');
    }
}
