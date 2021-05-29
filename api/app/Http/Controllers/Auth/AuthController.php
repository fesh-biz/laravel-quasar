<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\Auth\PasswordResetLinkRequested;
use App\Repository\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function register(UserRequest $r): JsonResponse
    {
        $userData = $r->getUserDataForRegistration();

        $user = $this->userRepo->createNewUser($userData);

        $client = Client::find(2);

        $response = \Http::asForm()->post(env('APP_URL') . '/api/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $userData['email'],
            'password' => $userData['password'],
            'scope' => null,
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

    public function passwordForgot(Request $r): JsonResponse
    {
        $email = $r->validate(
            [ 'email' => 'email|required|exists:users,email|max:255' ],
            [ 'email.exists' => trans('passwords.user') ]
        )['email'];

        $resetPasswordData = [
            'email' => $email,
            'token' => sha1(time()),
            'created_at' => now()
        ];

        \DB::table('password_resets')->insert($resetPasswordData);

        \Mail::to($email)->send(new PasswordResetLinkRequested($resetPasswordData));

        return response()->json(['status' => 'success']);
    }
}
