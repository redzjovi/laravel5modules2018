<?php

namespace Modules\User\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Role\Repositories\RoleRepository;
use Modules\User\Http\Requests\Backend\V1\User\StoreRequest;
use Modules\User\Http\Requests\Backend\V1\User\UpdateRequest;
use Modules\User\Repositories\Criterias\UserCriteria;
use Modules\User\Repositories\UserRepository;

class UserController extends \Modules\Cms\Http\Controllers\Backend\V1\RepositoryController
{
    protected $roleRepository;

    public function __construct(
        RoleRepository $roleRepository,
        UserRepository $repository
    )
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(app(\Prettus\Repository\Criteria\RequestCriteria::class));
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['model'] = $this->repository->getModel();
        $data['roles'] = $this->roleRepository->orderBy('name')->all();
        $data['users'] = $this->repository->with(['roles'])
            ->pushCriteria(new UserCriteria(request()->query()))
            ->paginate();
        return view('user::backend/v1/user/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = $this->repository->getModel();
        $data['roles'] = $this->roleRepository->orderBy('name')->all();
        return view('user::backend/v1/user/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $user = $this->repository->create($request->input());

        if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
            $user->syncRoles($request->input('role_name'));
        }

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
    public function edit($id)
    {
        $data['model'] = $this->repository->find($id);
        $data['roles'] = $this->roleRepository->orderBy('name')->all();
        return view('user::backend/v1/user/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        ! $request->input('password') ? $request->request->remove('password') : '';
        $user = $this->repository->update($request->input(), $id);

        if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
            $user->syncRoles($request->input('role_name'));
        }

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


    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $columns[] = trans('cms::cms.name');
        $columns[] = trans('cms::cms.email');
        if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
            $columns[] = trans('cms::cms.roles');
        }
        $csv->insertOne($columns);

        $users = $this->repository->all();
        $users->each(function ($user) use ($csv) {
            $columns = [];
            $columns[] = $user->name;
            $columns[] = $user->email;
            if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
                $columns[] = $user->roles->pluck('name')->implode(',');
            }
            $csv->insertOne($columns);
        });

        $csv->output($this->repository->getModel()->getTable().'_'.date('Ymd_His').'.csv');
    }
}
