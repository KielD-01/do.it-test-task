<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Github\Client;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{

    /** @var GitHubManager */
    private $github;

    public function __construct(GitHubManager $github)
    {
        parent::__construct();
        $this->github = $github;
    }

    /**
     * @param Request $request
     * @param GitHubManager $github
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailsToGitHubUsers(Request $request, GitHubManager $github)
    {

        /** @var User $user */
        $user = Auth::user();

        try {
            $github->authenticate($user->token, null, Client::AUTH_URL_TOKEN);
            $users = $request->post('users');

            foreach ($users as $index => $user) {
                $users[$index] = $this->checkUser($user);
            }

            $users = array_filter($users);

            return $this->jsonResponse(compact('users'));
        } catch (\Exception $exception) {
            return $this->jsonResponse(null, [$exception->getMessage()], 400);
        }
    }

    /**
     * @param null $gitHubUserName
     * @return null
     */
    private function checkUser($gitHubUserName = null)
    {
        if (!$gitHubUserName) {
            return null;
        }

        $user = $this->github->api('users')->show($gitHubUserName);

        return $user['email'] ? $user : null;
    }

}
