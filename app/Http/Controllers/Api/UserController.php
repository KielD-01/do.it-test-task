<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            /** @var User $user */
            $user = Auth::user();
            $user->oAuthTokens()->delete();

            $token = $user->createToken("{$user['email']}_api_token")
                ->accessToken;

            return $this->jsonResponse(compact('user', 'token'), null, 200);
        }

        return $this->jsonResponse(null, ['Wrong credentials'], 401);
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(UserRequest $request)
    {
        $user = User::create($request->post()); // ToDo : Move to UserRepositoryInterface Instead of temporary solution

        if ($user instanceof User) {
            return $this->jsonResponse(['message' => 'User has been successfully created'], [], 201);
        }

        return $this->jsonResponse([], ['Failed to create a user'], 409);
    }

}
