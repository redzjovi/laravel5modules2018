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

    public function store(\Modules\Authentication\Http\Requests\Api\Authentication\Login\StoreRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (! \Auth::attempt($credentials, $remember)) {
            return redirect()->back()->withErrors(['email' => [trans('auth.failed')]]);
        }

        if ($request->query('redirect_back_url')) {
            return redirect($request->query('redirect_back_url'));
        }

        return redirect()->route('modules.user.backend.v1.user.index');
    }
}
