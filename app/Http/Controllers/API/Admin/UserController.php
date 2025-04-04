<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\Exception;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return sendErrorResponse('Validation Error.', $validator->errors(), 400);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();

                $token = $user->createToken($request->email);

                $expirationTime = now()->addMinutes(config('sanctum.expiration'));
                $token->accessToken->expires_at = $expirationTime;
                $token->accessToken->save();

                $success['token'] =  $token->plainTextToken;
                $success['token_expiration_time'] =  $expirationTime;
                $success['user_id'] =  $user->id;
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
                $success['profile_pic'] =  $user->profile_pic;
                $success['user_type'] =  $user->user_type;

                // if ($user) {
                //     Session::put('user_email', $request->email);
                //     //Session::put('user_id', $user->id);
                // } else {
                //     Session::put('user_email', '');
                //     Session::put('user_id', '');
                // }

                return sendSuccessResponse('Login successful.', $success);
            } else {
                return sendErrorResponse('Unauthorised access.', 'Unauthorised', 401);
            }
        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();

            return sendSuccessResponse('User logged out successfully.', '');

        } catch (\Throwable $th) {
            return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
        }
    }

    // public function f1(Request $request): JsonResponse
    // {
    //     try {
    //         return sendSuccessResponse('Hello.', 1);
    //     } catch (\Throwable $th) {
    //         return sendErrorResponse('Something went wrong.', $th->getMessage(), 500);
    //     }
    // }
}
