<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use claviska\SimpleImage;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $this->uploadAvatar($request, $user);
            return $this->jsonResponse(['message' => 'User has been successfully created'], [], 201);
        }

        return $this->jsonResponse([], ['Failed to create a user'], 409);
    }

    /**
     * Uploads image
     *
     * @param Request $request
     * @param User $user
     * @return bool
     */
    private function uploadAvatar(Request $request, User $user)
    {
        $basePath = 'uploads' . DS . 'avatars' . DS . 'user_' . $user->id . DS;
        $imagesPaths = [
            'avatar' => [
                'main' => 'https://placehold.it/500x500',
                'thumbnail' => 'https://placehold.it/100x100'
            ]
        ];

        if ($request->hasFile('avatar')) {
            /** @var File $avatar */
            $avatar = $request->file('avatar');
            try {

                $path = public_path($basePath);

                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

                $imageProcessor = new SimpleImage($avatar);
                $imageProcessor->toFile($path . 'avatar.png', 'image/png');

                $imageProcessor->thumbnail(100, 100)
                    ->toFile($path . 'thumbnail.png', 'image/png');

                $user->avatar = [
                    'main' => DS . $basePath . 'avatar.png',
                    'thumbnail' => DS . $basePath . 'thumbnail.png'
                ];

                return $user->save();

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return false;
            }
        }

        return $user->save($imagesPaths);
    }

}
