<?php

namespace Modules\Authentication\Http\Controllers\Backend\V1\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->back();
    }
}
