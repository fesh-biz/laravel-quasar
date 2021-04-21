<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function me(): Authenticatable
    {
        return auth()->user();
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->delete();

        return response()->json('Success');
    }
}
