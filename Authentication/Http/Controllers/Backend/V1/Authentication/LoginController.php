<?php

namespace Modules\Authentication\Http\Controllers\Backend\V1\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('authentication::backend/v1/authentication/login/index');
    }

    public function store(\Modules\Authentication\Http\Requests\Api\V1\Authentication\Login\StoreRequest $request)
    {
        if (\Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            if ($request->query('url')) {
                return redirect($request->query('url'));
            }

            return redirect()->route('modules.user.backend.v1.user.index');
        } else {
            return redirect()->back()->withErrors(['email' => [trans('auth.failed')]]);
        }
    }
}
