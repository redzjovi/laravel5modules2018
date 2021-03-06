<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Http\Resources\Api\V1\CategoryResource;
use Modules\Category\Models\Category;

/**
 * @group Category
 */
class CategoryController extends Controller
{
    /**
     * Index
     * @queryParam id Id (number)
     * @queryParam title Title
     * @queryParam slug Slug
     * @queryParam excerpt Excerpt
     * @queryParam sort Sort ie. sort=title,-title,slug,-slug,excerpt,-excerpt,updated_at,-updated_at
     * @queryParam with[] With ie. with[]=translations
     * @queryParam per_page Per page (number)
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "title": "Category1 En",
     *          "slug": "category1-en-1",
     *          "excerpt": "Excerpt1 En",
     *          "content": "Content1 En",
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
        $categories = Category::getCategories($parameters);

        return CategoryResource::collection($categories);
    }

    /**
     * Store
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam title_en text required Title
     * @bodyParam excerpt_en text Excerpt
     * @bodyParam content_en text Content
     * @bodyParam image[] image Image
     * @bodyParam gallery[] image Gallery
     * @response {
     *  "data": {
     *      "id": 1,
     *      "title": "Category1 En",
     *      "slug": "category1-en-1",
     *      "excerpt": "Excerpt1 En",
     *      "content": "Content1 En",
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
    public function store(\Modules\Category\Http\Requests\Api\V1\Category\StoreRequest $request)
    {
        $category = Category::createCategory($request->all());
        return new CategoryResource($category);
    }

    /**
     * Show
     * {category} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @response {
     *  "data": {
     *      "id": 1,
     *      "title": "Category1 En",
     *      "slug": "category1-en-1",
     *      "excerpt": "Excerpt1 En",
     *      "content": "Content1 En",
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
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update
     * {category} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @bodyParam title_en text required Title
     * @bodyParam excerpt_en text Excerpt
     * @bodyParam content_en text Content
     * @bodyParam image[] image Image
     * @bodyParam image_id[] number Image id
     * @bodyParam gallery[] image Gallery
     * @bodyParam gallery_id[] number Gallery id
     * @response
     *  "data": {
     *      "id": 1,
     *      "title": "Category1 En",
     *      "slug": "category1-en-1",
     *      "excerpt": "Excerpt1 En",
     *      "content": "Content1 En",
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
    public function update(\Modules\Category\Http\Requests\Api\V1\Category\UpdateRequest $request, Category $category)
    {
        $category = Category::updateCategoryById($request->all(), $category->id);
        return new CategoryResource($category);
    }

    /**
     * Destroy
     * {category} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Category $category)
    {
        $data['count'] = Category::deleteModel($category->id);
        return response()->json($data);
    }
}
