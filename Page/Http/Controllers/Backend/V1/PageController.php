<?php

namespace Modules\Page\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\Http\Requests\Api\V1\Page\StoreRequest;
use Modules\Page\Http\Requests\Api\V1\Page\UpdateRequest;
use Modules\Page\Repositories\PageRepository;

class PageController extends \Modules\Cms\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $parameters = request()->query();
        $parameters['paginate'] = 1;

        $data['model'] = new PageRepository;
        $data['pages'] = PageRepository::getPages($parameters);

        return view('page::backend/v1/page/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new PageRepository;

        return view('page::backend/v1/page/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        PageRepository::createAttributes($request->input());
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
        $data['model'] = PageRepository::findById($id);

        return view('page::backend/v1/page/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        PageRepository::updateAttributesById($request->input(), $id);
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
                        PageRepository::deleteById($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(int $id)
    {
        PageRepository::deleteById($id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $columns[] = trans('cms::cms.title');
        $columns[] = trans('cms::cms.slug');
        $columns[] = trans('cms::cms.excerpt');
        $columns[] = trans('cms::cms.content');
        $csv->insertOne($columns);

        $pages = PageRepository::getPages($request->query());
        $pages->each(function ($page) use ($csv) {
            $columns = [];
            $columns[] = $page->title;
            $columns[] = $page->slug;
            $columns[] = $page->excerpt;
            $columns[] = $page->content;
            $csv->insertOne($columns);
        });

        $csv->output('page_'.date('Ymd_His').'.csv');
    }
}
