<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 201,
            'message' => 'Successfully Register',
        ], 201);
    }

    public function login(): JsonResponse
    {
        return response()->json([
            'status' => 201,
            'message' => 'Successfully Login',
        ], 201);
    }
}
