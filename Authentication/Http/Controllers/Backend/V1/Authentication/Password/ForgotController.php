<?php

namespace Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Repositories\UserRepository;

class ForgotController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('authentication::backend/v1/authentication/password/forgot/index');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Authentication\Http\Requests\Api\V1\Authentication\Password\Forgot\StoreRequest $request)
    {
        $user = $this->repository->findByField('email', $request->input('email'))->first();

        $attributes['verification_code'] = rand(111111, 999999);
        $user = $this->repository->update($attributes, $user->id);

        $user->notify(new \Modules\Authentication\Notifications\PasswordResetLink($user));

        flash(trans('passwords.sent'))->success()->important();
        return redirect()->back();
    }
}
