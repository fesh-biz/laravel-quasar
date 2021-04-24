<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repository\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function me(): Authenticatable
    {
        return auth()->user();
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->delete();

        return response()->json('Success');
    }

    public function register(UserRequest $r)
    {
        $userData = $r->getUserDataForRegistration();

        $user = $this->userRepo->createNewUser($userData);

        $client = Client::find(2);

        $response = \Http::asForm()->post(env('APP_URL') . '/api/token', [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $userData['email'],
            'password'      => $userData['password'],
            'scope'         => null,
        ]);

        $response = $response->object();

        return response()->json([
            'access_token' => $response->access_token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}
