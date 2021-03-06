<?php

namespace Modules\Page\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\Models\Category;
use Modules\Page\Http\Requests\Api\V1\Page\StoreRequest;
use Modules\Page\Http\Requests\Api\V1\Page\UpdateRequest;
use Modules\Page\Models\Page;
use Modules\Tag\Models\Tag;

class PageController extends \Modules\Cms\Http\Controllers\Controller
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

        $data['categories'] = Category::getCategories(['id' => request()->query('category_id', [0])]);
        $data['model'] = new Page;
        $data['pages'] = Page::getPages($parameters);
        $data['tags'] = Tag::getTags(['id' => request()->query('tag_id', [0])]);

        return view('page::backend/v1/page/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Page;

        return view('page::backend/v1/page/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Page::createPage($request->all());
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
    public function edit(Page $page)
    {
        $data['model'] = $page;

        return view('page::backend/v1/page/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Page $page)
    {
        Page::updatePageById($request->all(), $page->id);
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
                        Page::deleteModel($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Page $page)
    {
        Page::deleteModel($page->id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        foreach (config('cms.locales') as $locale => $locales) {
            $columns[] = trans('cms::cms.title').' '.$locale;
            $columns[] = trans('cms::cms.slug').' '.$locale;
            $columns[] = trans('cms::cms.excerpt').' '.$locale;
            $columns[] = trans('cms::cms.content').' '.$locale;
        }
        $csv->insertOne($columns);

        $pages = Page::getPages($request->query());
        $pages->each(function ($page) use ($csv) {
            $columns = [];
            foreach (config('cms.locales') as $locale => $locales) {
                $columns[] = $page->{'title_'.$locale};
                $columns[] = $page->{'slug_'.$locale};
                $columns[] = $page->{'excerpt_'.$locale};
                $columns[] = $page->{'content_'.$locale};
            }
            $csv->insertOne($columns);
        });

        $csv->output('page_'.date('Ymd_His').'.csv');
    }
}
