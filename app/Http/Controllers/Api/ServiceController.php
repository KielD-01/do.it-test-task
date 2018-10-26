<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;

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

        foreach ($users as $user) {

        }

        return $this->jsonResponse(compact('users'));
    }

}
