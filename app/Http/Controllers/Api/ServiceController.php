<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param GitHubManager $github
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailsToGitHubUsers(Request $request, GitHubManager $github)
    {
        $users = $request->post('users');

        /** @var User $user */
        $user = Auth::user();
        $github->authenticate($user->api_token);

        foreach ($users as $index => $user) {
            $users[$index] = $github;
        }

        return $this->jsonResponse(compact('users'));
    }

}
