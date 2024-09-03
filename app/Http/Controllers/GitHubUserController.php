<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHubUserController extends Controller
{
    private $githubApiUrl = 'https://api.github.com/';

    private function getGitHubHeaders()
    {
        return [
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
            'Accept' => 'application/vnd.github.v3+json',
        ];
    }

    public function index()
    {
        return view('github.index');
    }

    public function search(Request $request)
    {
        $username = $request->get('username');
        $user = Http::withHeaders($this->getGitHubHeaders())->withOptions([
        'verify' => false,
    ])->get($this->githubApiUrl ."users/{$username}")->json();
        $followers = Http::withHeaders($this->getGitHubHeaders())->withOptions([
        'verify' => false,
    ])->get($this->githubApiUrl ."users/{$username}/followers?per_page=10")->json();

        return response()->json([
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    public function loadFollowers(Request $request)
    {
        $username = $request->get('username');
        $page = $request->get('page', 1);
        $followers = Http::withHeaders($this->getGitHubHeaders())->withOptions([
        'verify' => false,
    ])->get($this->githubApiUrl ."users/{$username}/followers?per_page=10&page={$page}")->json();

        return response()->json($followers);
    }
}
