<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @group Auth endpoints
 */
class AuthController extends Controller
{
    /**
     * Login user endpoint
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->validated())) {
            return response()->json([
                'status'  => 'err',
                'message' => 'Login fail'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user'  => $user,
            'token' => $user->createToken('app')->accessToken,
        ]);
    }

    /**
     * User info endpoint
     *
     * @authenticated
     * @header Content-Type application/json
     */
    public function me(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
