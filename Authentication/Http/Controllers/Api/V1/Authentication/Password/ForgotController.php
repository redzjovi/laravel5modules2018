<?php

namespace Modules\Authentication\Http\Controllers\Api\V1\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Models\User;

class ForgotController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('authentication::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('authentication::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Authentication\Http\Requests\Api\V1\Authentication\Password\Forgot\StoreRequest $request)
    {
        $user = User::findModelByField('email', $request->input('email'));
        $user = User::updateVerificationCodeById($user->id);
        $user->notify(new \Modules\Authentication\Notifications\PasswordResetLink($user));

        return response()->json(['message' => trans('cms::cms.success')]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('authentication::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('authentication::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
