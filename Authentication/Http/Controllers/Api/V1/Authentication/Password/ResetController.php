<?php

namespace Modules\Authentication\Http\Controllers\Api\V1\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Models\User;

class ResetController extends Controller
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
    public function store(Request $request)
    {
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
    public function update(\Modules\Authentication\Http\Requests\Api\V1\Authentication\Password\Reset\UpdateRequest $request)
    {
        $user = User::getUserByEmailAndVerificationCode(
            $request->input('email'),
            $request->input('verification_code')
        );

        if ($user) {
            User::updatePasswordAndVerificationCodeById(
                $request->input('password'),
                $user->id
            );
            return response()->json(['message' => trans('cms::cms.success')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
