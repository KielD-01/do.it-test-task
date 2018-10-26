<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendEmails;
use App\Mail\TestMail;
use App\Models\User;
use Github\Client;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{

    /** @var GitHubManager */
    private $github;

    /**
     * ServiceController constructor.
     * @param GitHubManager $github
     */
    public function __construct(GitHubManager $github)
    {
        parent::__construct();
        $this->github = $github;
    }

    /**
     * Preparing emails to be sent
     *
     * @param SendEmails $request
     * @param GitHubManager $github
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailsToGitHubUsers(SendEmails $request, GitHubManager $github)
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

            $this->sendMail(
                $users,
                $request->post('message', 'Here we do have no content :(')
            );

            return $this->jsonResponse([
                'message' => 'Emails has been sent to the recipients',
                'recipients' => $users
            ], [], 200);

        } catch (\Exception $exception) {
            return $this->jsonResponse(null, [$exception->getMessage()], 422);
        }
    }

    /**
     * Check the User from the GitHub
     *
     * @param null|string $gitHubUserName
     * @return null
     */
    private function checkUser($gitHubUserName = null)
    {
        if (!$gitHubUserName) {
            return null;
        }

        $user = $this->github->api('users')->show($gitHubUserName);

        return $user['email'] ?? null;
    }

    /**
     * Sending an email
     *
     * @param array $emails
     * @param null $message
     * @return bool|mixed
     */
    private function sendMail($emails = [], $message = null)
    {
        if (!$message || !$emails) {
            return false;
        }

        return Mail::to($emails)
            ->send(new TestMail($message));
    }

}
