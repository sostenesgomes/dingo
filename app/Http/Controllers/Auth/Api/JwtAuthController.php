<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

/**
 * Class JwtAuthController
 * @package App\Http\Controllers\Auth\Api
 */
class JwtAuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['logout' => true]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'jwt_error'], 500);
        }

        return response()->json(['error' => 'jtw_error'], 500);
    }
}