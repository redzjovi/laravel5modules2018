<?php

namespace Modules\Menu\Http\Controllers\Api\V1\Menu\Nestable;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Menu\Http\Resources\Api\V1\Menu\Nestable\TypeTitleResource;

/**
 * @group Menu
 */
class TypeTitleController extends Controller
{
    /**
     * menu/nestable/type-title GET
     * @queryParam type Type ie. type=category, type=page, type=tag, type=user
     * @queryParam type_title Title
     * @queryParam per_page Per page (number)
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "title": "Page1 En",
     *          "created_at": {
     *              "date": "2019-02-20 14:54:56.000000",
     *              "timezone_type": 3,
     *              "timezone": "Asia/Jakarta"
     *          },
     *          "updated_at": {
     *              "date": "2019-03-07 18:53:23.000000",
     *              "timezone_type": 3,
     *              "timezone": "Asia/Jakarta"
     *          }
     *      }
     *  ]
     * }
     */
    public function index(Request $request)
    {
        $parameters = $request->query();

        if ($request->query('type') == 'category') {
            $parameters['title'] = $request->query('type_title');
            $resource = \Modules\Category\Models\Category::getCategories($parameters);
        } elseif ($request->query('type') == 'tag') {
            $parameters['title'] = $request->query('type_title');
            $resource = \Modules\Tag\Models\Tag::getTags($parameters);
        } elseif ($request->query('type') == 'user') {
            $parameters['name'] = $request->query('type_title');
            $resource = \Modules\User\Models\User::getUsers($parameters);
        } else {
            $parameters['title'] = $request->query('type_title');
            $resource = \Modules\Page\Models\Page::getPages($parameters);
        }

        return TypeTitleResource::collection($resource);
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
