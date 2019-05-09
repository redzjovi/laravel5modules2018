<?php

namespace Modules\Category\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\Http\Requests\Api\V1\Category\StoreRequest;
use Modules\Category\Http\Requests\Api\V1\Category\UpdateRequest;
use Modules\Category\Models\Category;

class CategoryController extends \Modules\Cms\Http\Controllers\Controller
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

        $data['model'] = new Category;
        $data['categories'] = Category::getCategories($parameters);

        return view('category::backend/v1/category/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Category;

        return view('category::backend/v1/category/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Category::createCategory($request->all());
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
    public function edit(Category $category)
    {
        $data['model'] = $category;

        return view('category::backend/v1/category/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Category $category)
    {
        Category::updateCategoryById($request->all(), $category->id);
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
                        Category::deleteModel($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Category $category)
    {
        Category::deleteModel($category->id);
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

        $categories = Category::getCategories($request->query());
        $categories->each(function ($category) use ($csv) {
            $columns = [];
            foreach (config('cms.locales') as $locale => $locales) {
                $columns[] = $category->{'title_'.$locale};
                $columns[] = $category->{'slug_'.$locale};
                $columns[] = $category->{'excerpt_'.$locale};
                $columns[] = $category->{'content_'.$locale};
            }
            $csv->insertOne($columns);
        });

        $csv->output('category_'.date('Ymd_His').'.csv');
    }
}
