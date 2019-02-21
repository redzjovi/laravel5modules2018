<?php

namespace Modules\Medium\Http\Controllers\Api\V1\Medium\Tinymce;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medium\Http\Requests\Api\V1\Medium\Tinymce\Image\StoreRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
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
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        //
    }
}
