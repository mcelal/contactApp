<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
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
            'data'   => [
                'user' => $user,
                'token' => $user->createToken('app')->accessToken,
            ]
        ]);
    }

    /**
     * User info endpoint
     *
     * @authenticated
     * @header Content-Type application/json
     * @header Authorization Bearer
     */
    public function me()
    {
        return Auth::user();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
