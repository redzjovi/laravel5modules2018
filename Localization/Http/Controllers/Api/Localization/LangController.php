<?php

namespace Modules\Localization\Http\Controllers\Api\Localization;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * @group Localization
 */
class LangController extends Controller
{
    /**
     * lang GET
     * @response {
     *  "data": {
     *          "about": "About",
     *          "account": "Account",
     *          "account_information": "Account Information"
     *  }
     * }
     */
    public function index()
    {
        $data['data'] = trans('cms::cms');

        return response()->json($data);
    }
}
