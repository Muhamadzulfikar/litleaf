<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $payload = $request->all();
            $payload['password'] = bcrypt($request->password);

            $user = User::create($payload);

            $token = $user->createToken('LitleafToken')->accessToken;

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 201,
            'message' => 'Successfully Register',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if (! auth()->attempt($request->all())) {
                throw new \Exception('Incorrect Details. Please try again');
            }

            $token = auth()->user()->createToken('LitleafToken')->accessToken;
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Successfully Login',
            'data' => [
                'user' => auth()->user(),
                'token' => $token,
            ],
        ], 201);
    }
}
