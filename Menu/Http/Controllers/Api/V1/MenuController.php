<?php

namespace Modules\Menu\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Menu\Http\Resources\Api\V1\MenuResource;
use Modules\Menu\Models\Menu;

/**
 * @group Menu
 */
class MenuController extends Controller
{
    /**
     * Index
     * @queryParam id Id (number)
     * @queryParam title Title
     * @queryParam excerpt Excerpt
     * @queryParam sort Sort ie. sort=title,-title,excerpt,-excerpt,updated_at,-updated_at
     * @queryParam with[] With ie. with[]=translations
     * @queryParam per_page Per page (number)
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "title": "Menu1 En",
     *          "excerpt": "Excerpt1 En",
     *          "images": [],
     *          "galleries": [],
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
        $menus = Menu::getMenus($parameters);

        return MenuResource::collection($menus);
    }

    /**
     * Store
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam title_en text required Title
     * @bodyParam excerpt_en text Excerpt
     * @bodyParam image[] image Image
     * @bodyParam gallery[] image Gallery
     * @response {
     *  "data": {
     *      "id": 1,
     *      "title": "Menu1 En",
     *      "excerpt": "Excerpt1 En",
     *      "images": [],
     *      "galleries": [],
     *      "created_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "title_en": [
     *          "The title en field is required."
     *      ],
     *      "image.0": [
     *          "The image.0 must be an image."
     *      ],
     *      "gallery.0": [
     *          "The gallery.0 must be an image."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Menu\Http\Requests\Api\V1\Menu\StoreRequest $request)
    {
        $menu = Menu::createMenu($request->all());
        return new MenuResource($menu);
    }

    /**
     * Show
     * {menu} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @response {
     *  "data": {
     *      "id": 1,
     *      "title": "Menu1 En",
     *      "excerpt": "Excerpt1 En",
     *      "images": [],
     *      "galleries": [],
     *      "created_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update
     * {menu} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam title_en text required Title
     * @bodyParam excerpt_en text Excerpt
     * @bodyParam image[] image Image
     * @bodyParam image_id[] number Image id
     * @bodyParam gallery[] image Gallery
     * @bodyParam gallery_id[] number Gallery id
     * @response
     *  "data": {
     *      "id": 1,
     *      "title": "Menu1 En",
     *      "excerpt": "Excerpt1 En",
     *      "images": [],
     *      "galleries": [],
     *      "created_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-12 10:17:42.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "title_en": [
     *          "The title en field is required."
     *      ],
     *      "image.0": [
     *          "The image.0 must be an image."
     *      ],
     *      "gallery.0": [
     *          "The gallery.0 must be an image."
     *      ]
     *  }
     * }
     */
    public function update(\Modules\Menu\Http\Requests\Api\V1\Menu\UpdateRequest $request, Menu $menu)
    {
        $menu = Menu::updateMenuById($request->all(), $menu->id);
        return new MenuResource($menu);
    }

    /**
     * Destroy
     * {menu} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Menu $menu)
    {
        $data['count'] = Menu::deleteModel($menu->id);
        return response()->json($data);
    }
}
