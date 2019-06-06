<?php

namespace Modules\Theme\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Theme\Http\Resources\Api\V1\ThemeResource;
use Modules\Theme\Models\Theme;

/**
 * @group Theme
 */
class ThemeController extends Controller
{
    /**
     * theme GET
     * @queryParam id Id (number)
     * @queryParam group Group
     * @queryParam section Section
     * @queryParam type Type
     * @queryParam value Value
     * @queryParam title Title
     * @queryParam content Content
     * @queryParam sort Sort ie. sort=id,-id,group,-group,section,-section,menu,-menu,value,-value,title,-title,content,-content,created_at,-created_at,updated_at,-updated_at
     * @queryParam with[] With ie. with[]=translations
     * @queryParam per_page Per page (number)
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "group": "group_1",
     *          "section": "section_1",
     *          "type": "page",
     *          "value": "value",
     *          "title": "Theme1 En",
     *          "content": "Content1 En",
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
        $pages = Theme::getThemes($parameters);

        return ThemeResource::collection($pages);
    }

    /**
     * theme POST
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam group text required Group
     * @bodyParam section text required Section
     * @bodyParam type text required Type
     * @bodyParam value text Value
     * @bodyParam title_en text required Title
     * @bodyParam content_en text Content
     * @response {
     *  "data": {
     *      "id": 1,
     *      "group": "group_1",
     *      "section": "section_1",
     *      "type": "page",
     *      "value": "value",
     *      "title_en": "Title1 En",
     *      "content_en": "Content1 En",
     *      "created_at": {
     *          "date": "2019-02-20 14:54:56.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-07 18:53:23.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *      "group": [
     *          "The group field is required."
     *      ],
     *      "section": [
     *          "The section field is required."
     *      ],
     *      "type": [
     *          "The type field is required."
     *      ]
     *  }
     * }
     */
    public function store(\Modules\Theme\Http\Requests\Api\V1\Theme\StoreRequest $request)
    {
        $page = Theme::createTheme($request->all());
        return new ThemeResource($page);
    }

    /**
     * theme/{theme} GET
     * {theme} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @response {
     *  "data": {
     *      "id": 1,
     *      "group": "group_1",
     *      "section": "section_1",
     *      "type": "page",
     *      "value": "value",
     *      "title_en": "Title1 En",
     *      "content_en": "Content1 En",
     *      "created_at": {
     *          "date": "2019-02-20 14:54:56.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-07 18:53:23.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      }
     *  }
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function show(Theme $theme)
    {
        return new ThemeResource($theme);
    }

    /**
     * theme/{theme} PUT
     * {theme} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam group text required Group
     * @bodyParam section text required Section
     * @bodyParam type text required Type
     * @bodyParam value text Value
     * @bodyParam title_en text required Title
     * @bodyParam content_en text Content
     * @response
     *  "data": {
     *      "id": 1,
     *      "group": "group_1",
     *      "section": "section_1",
     *      "type": "page",
     *      "value": "value",
     *      "title_en": "Title1 En",
     *      "content_en": "Content1 En",
     *      "created_at": {
     *          "date": "2019-02-20 14:54:56.000000",
     *          "timezone_type": 3,
     *          "timezone": "Asia/Jakarta"
     *      },
     *      "updated_at": {
     *          "date": "2019-03-07 18:53:23.000000",
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
     *      "group": [
     *          "The group field is required."
     *      ],
     *      "section": [
     *          "The section field is required."
     *      ],
     *      "type": [
     *          "The type field is required."
     *      ]
     *  }
     * }
     */
    public function update(\Modules\Theme\Http\Requests\Api\V1\Theme\UpdateRequest $request, Theme $theme)
    {
        $theme = Theme::updateThemeById($request->all(), $theme->id);
        return new ThemeResource($theme);
    }

    /**
     * theme/{theme} DELETE
     * {theme} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Theme $theme)
    {
        $data['count'] = Theme::deleteModel($theme->id);
        return response()->json($data);
    }
}
