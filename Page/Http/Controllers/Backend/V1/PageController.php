<?php

namespace Modules\Page\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\Http\Requests\Api\V1\Page\StoreRequest;
use Modules\Page\Http\Requests\Api\V1\Page\UpdateRequest;
use Modules\Page\Repositories\Criterias\PageCriteria;
use Modules\Page\Repositories\PageRepository;

class PageController extends \Modules\Cms\Http\Controllers\Backend\V1\RepositoryController
{
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(app(\Prettus\Repository\Criteria\RequestCriteria::class));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['model'] = $this->repository->getModel();
        $data['pages'] = $this->repository
            ->pushCriteria(new PageCriteria(request()->query()))
            ->paginate();
        return view('page::backend/v1/page/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = $this->repository->getModel();
        return view('page::backend/v1/page/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $this->repository->create($request->input());
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
        return view('page::backend/v1/page/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        ! $request->input('password') ? $request->request->remove('password') : '';
        $this->repository->update($request->input(), $id);
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
        $csv->insertOne($columns);

        $pages = $this->repository->all();
        $pages->each(function ($page) use ($csv) {
            $columns = [];
            $columns[] = $page->name;
            $columns[] = $page->email;
            $csv->insertOne($columns);
        });

        $csv->output($this->repository->getModel()->getTable().'_'.date('Ymd_His').'.csv');
    }
}
