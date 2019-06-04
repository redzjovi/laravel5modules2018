<?php

namespace Modules\Menu\Http\Controllers\Api\V1\Menu\Nestable;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @group Menu
 */
class TypeController extends Controller
{
    /**
     * menu/nestable/type GET
     * @response 200 {
     *      "data": {
     *          "category": "Category",
     *          "page": "Page",
     *          "tag": "Tag",
     *          "user": "User"
     *      }
     * }
     */
    public function index()
    {
        $json['data'] = [
            'category' => trans('cms::cms.category'),
            'page' => trans('cms::cms.page'),
            'tag' => trans('cms::cms.tag'),
            'user' => trans('cms::cms.user'),
        ];

        return response()->json($json);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('menu::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('menu::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('menu::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
