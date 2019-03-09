<?php

namespace Modules\User\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Api\V1\User\StoreRequest;
use Modules\User\Http\Requests\Api\V1\User\UpdateRequest;
use Modules\User\Http\Resources\Api\V1\UserResource;
use Modules\User\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $parameters = $request->query();
        $users = User::getUsers($parameters);

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $user = User::createUser($request->all());
        return new UserResource($user);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user = User::updateUserById($request->all(), $user->id);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(User $user)
    {
        $data['count'] = User::deleteUserById($user->id);
        return response()->json($data);
    }
}
