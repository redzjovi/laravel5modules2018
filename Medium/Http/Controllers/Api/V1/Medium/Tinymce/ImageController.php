<?php

namespace Modules\Medium\Http\Controllers\Api\V1\Medium\Tinymce;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medium\Http\Requests\Api\V1\Medium\Tinymce\Image\StoreRequest;

/**
 * @group Medium
 * @bodyParam file file required File
 */
class ImageController extends Controller
{
    /**
     * Tinymce image
     * @bodyParam file file required File
     * @response {
     *  "data": {
     *      "location": "http://laravel5skeleton2018.docker/storage/tinymce/2019/03/12/20190312-070717--All"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *      "file": [
     *          "The file field is required."
     *      ]
     *  },
     *  "message": "The file field is required."
     * }
     */
    public function store(StoreRequest $request)
    {
        $storage = \Storage::disk('tinymce');
        $url = $storage->putFileAs(
            date('Y').'/'.date('m').'/'.date('d'),
            $request->file('file'),
            date('Ymd-His').'--'.$request->file('file')->getClientOriginalName()
        );

        $data['data']['location'] = $storage->url($url);

        return response()->json($data);
    }
}
