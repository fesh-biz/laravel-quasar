<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
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
