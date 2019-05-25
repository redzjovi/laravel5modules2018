<?php

namespace Modules\Menu\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Menu\Http\Requests\Api\V1\Menu\StoreRequest;
use Modules\Menu\Http\Requests\Api\V1\Menu\UpdateRequest;
use Modules\Menu\Models\Menu;

class MenuController extends \Modules\Cms\Http\Controllers\Controller
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

        $data['model'] = new Menu;
        $data['menus'] = Menu::getMenus($parameters);

        return view('menu::backend/v1/menu/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['model'] = new Menu;

        return view('menu::backend/v1/menu/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        Menu::createMenu($request->all());
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
    public function edit(Menu $menu)
    {
        $data['model'] = $menu;

        return view('menu::backend/v1/menu/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, Menu $menu)
    {
        Menu::updateMenuById($request->all(), $menu->id);
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
                        Menu::deleteModel($id);
                    }
                    flash(trans('cms::cms.deleted').' ('.count($ids).')')->important()->success();
                }
            }
        }

        return redirect()->back();
    }

    public function delete(Menu $menu)
    {
        Menu::deleteModel($menu->id);
        flash(trans('cms::cms.deleted'))->important()->success();
        return redirect()->back();
    }

    public function exportCsv(Request $request)
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        foreach (config('cms.locales') as $locale => $locales) {
            $columns[] = trans('cms::cms.title').' '.$locale;
            $columns[] = trans('cms::cms.excerpt').' '.$locale;
        }
        $csv->insertOne($columns);

        $menus = Menu::getMenus($request->query());
        $menus->each(function ($menu) use ($csv) {
            $columns = [];
            foreach (config('cms.locales') as $locale => $locales) {
                $columns[] = $menu->{'title_'.$locale};
                $columns[] = $menu->{'excerpt_'.$locale};
            }
            $csv->insertOne($columns);
        });

        $csv->output('menu_'.date('Ymd_His').'.csv');
    }
}
