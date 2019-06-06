<?php

namespace Modules\Theme\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Theme\Http\Requests\Api\V1\Theme\StoreRequest;
use Modules\Theme\Http\Requests\Api\V1\Theme\UpdateRequest;
use Modules\Theme\Models\Theme;

class ThemeController extends \Modules\Cms\Http\Controllers\Controller
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

        $data['model'] = new Theme;
        $data['themes'] = Theme::getThemes($parameters);

        return view('theme::backend/v1/theme/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Theme;

        return view('theme::backend/v1/theme/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Theme::createTheme($request->all());
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
    public function edit(Theme $theme)
    {
        $data['model'] = $theme;

        return view('theme::backend/v1/theme/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Theme $theme)
    {
        Theme::updateThemeById($request->all(), $theme->id);
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
                        Theme::deleteModel($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Theme $theme)
    {
        Theme::deleteModel($theme->id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $columns[] = trans('cms::cms.group');
        $columns[] = trans('cms::cms.section');
        $columns[] = trans('cms::cms.type');
        $columns[] = trans('cms::cms.value');
        foreach (config('cms.locales') as $locale => $locales) {
            $columns[] = trans('cms::cms.title').' '.$locale;
            $columns[] = trans('cms::cms.content').' '.$locale;
        }
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne($columns);

        $themes = Theme::getThemes($request->query());
        $themes->each(function ($theme) use ($csv) {
            $columns[] = $theme->group;
            $columns[] = $theme->section;
            $columns[] = $theme->type;
            $columns[] = $theme->value;
            foreach (config('cms.locales') as $locale => $locales) {
                $columns[] = $theme->{'title_'.$locale};
                $columns[] = $theme->{'content_'.$locale};
            }
            $csv->insertOne($columns);
        });

        $csv->output('theme_'.date('Ymd_His').'.csv');
    }
}
