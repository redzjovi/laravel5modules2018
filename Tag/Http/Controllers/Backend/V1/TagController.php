<?php

namespace Modules\Tag\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Tag\Http\Requests\Api\V1\Tag\StoreRequest;
use Modules\Tag\Http\Requests\Api\V1\Tag\UpdateRequest;
use Modules\Tag\Models\Tag;

class TagController extends \Modules\Cms\Http\Controllers\Controller
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

        $data['model'] = new Tag;
        $data['tags'] = Tag::getTags($parameters);

        return view('tag::backend/v1/tag/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Tag;

        return view('tag::backend/v1/tag/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Tag::createTag($request->all());
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
    public function edit(Tag $tag)
    {
        $data['model'] = $tag;

        return view('tag::backend/v1/tag/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        Tag::updateTagById($request->all(), $tag->id);
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
                        Tag::deleteModel($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Tag $tag)
    {
        Tag::deleteModel($tag->id);
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

        $tags = Tag::getTags($request->query());
        $tags->each(function ($tag) use ($csv) {
            $columns = [];
            foreach (config('cms.locales') as $locale => $locales) {
                $columns[] = $tag->{'title_'.$locale};
                $columns[] = $tag->{'slug_'.$locale};
                $columns[] = $tag->{'excerpt_'.$locale};
                $columns[] = $tag->{'content_'.$locale};
            }
            $csv->insertOne($columns);
        });

        $csv->output('tag_'.date('Ymd_His').'.csv');
    }
}
