<?php

namespace Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Repositories\UserRepository;

class ResetController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $user = $this->repository->findWhere(['email' => $request->query('email'), 'verification_code' => $request->query('verification_code')])->first();

        if ($user) {
            $data['user'] = $user;
            return view('authentication::backend/v1/authentication/password/reset/index', $data);
        }
    }

    public function update(\Modules\Authentication\Http\Requests\Api\V1\Authentication\Password\Reset\UpdateRequest $request)
    {
        $user = $this->repository->findWhere(['email' => $request->input('email'), 'verification_code' => $request->input('verification_code')])->first();

        if ($user) {
            $attributes['password'] = $request->input('password');
            $attributes['verification_code'] = rand(111111, 999999);
            $this->repository->update($attributes, $user->id);
            flash(trans('passwords.reset'))->success()->important();
            return redirect()->route('modules.authentication.backend.v1.authentication.login.index');
        }
    }
}
