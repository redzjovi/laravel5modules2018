<?php

namespace Modules\Tag\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Tag\Http\Resources\Api\V1\TagResource;
use Modules\Tag\Models\Tag;

/**
 * @group Tag
 */
class TagController extends Controller
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
     *          "title": "Tag1 En",
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
        $tags = Tag::getTags($parameters);

        return TagResource::collection($tags);
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
     *      "title": "Tag1 En",
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
    public function store(\Modules\Tag\Http\Requests\Api\V1\Tag\StoreRequest $request)
    {
        $tag = Tag::createTag($request->all());
        return new TagResource($tag);
    }

    /**
     * Show
     * {tag} number required Id
     * @queryParam with[] With ie. with[]=translations
     * @response {
     *  "data": {
     *      "id": 1,
     *      "title": "Tag1 En",
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
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update
     * {tag} number required Id
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
     *      "title": "Tag1 En",
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
    public function update(\Modules\Tag\Http\Requests\Api\V1\Tag\UpdateRequest $request, Tag $tag)
    {
        $tag = Tag::updateTagById($request->all(), $tag->id);
        return new TagResource($tag);
    }

    /**
     * Destroy
     * {tag} number required Id
     * @response {
     *  "count": 1
     * }
     * @response 404 {
     *  "message": "Data not found"
     * }
     */
    public function destroy(Tag $tag)
    {
        $data['count'] = Tag::deleteModel($tag->id);
        return response()->json($data);
    }
}
