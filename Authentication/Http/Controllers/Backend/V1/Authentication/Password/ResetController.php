<?php

namespace Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Models\User;

class ResetController extends Controller
{
    public function index(Request $request)
    {
        $user = User::getUserByEmailAndPasswordAndVerificationCode(
            $request->query('email'),
            $request->query('p'),
            $request->query('verification_code')
        );

        if ($user) {
            $data['user'] = $user;
            return view('authentication::backend/v1/authentication/password/reset/index', $data);
        }
    }

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
            flash(trans('passwords.reset'))->success()->important();
            return redirect()->route('modules.authentication.backend.v1.authentication.login.index');
        }
    }
}
