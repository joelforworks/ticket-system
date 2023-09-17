<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * Create a user 
     *
     * @return json with token
     */
    public function register(Request $request)
    {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateUserStoreData();


        // Make  new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        // Save role and password for JWTAuth token
        $credentials = $request->only('email', 'password');


        // Return response and user token
        return response()->json([
            'message' => 'User created',
            'token' => JWTAuth::attempt($credentials),
            'user' => $user
        ], Response::HTTP_CREATED);
    }


    /**
     * Login  a user 
     *
     * @return json with token
     */
    public function login(Request $request)
    {
        // Only want email and password
        $credentials = $request->only('email', 'password');
        //Validaciones
        $validator = Validator::make($credentials, [
            'email' => 'required|string',
            //'password' => 'required|string|min:6|max:50'
        ]);
        // Return validate error if somethig is wrong
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Attempt to authenticate
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                // Incorrent Credentials .
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }
            // Get token expiration 
            $exp = JWTAuth::setToken($token)->getPayload()->get('exp');
            $expirationTime = $exp;
            $currentTime = time();
            $minutesToExpire = round(($expirationTime - $currentTime) / 60);
        } catch (JWTException $e) {
            //Error <chungo>chungo</chungo>
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
        return response()->json([
            'token' => $token,
            "minutes_to_expire" => $minutesToExpire,
            'user' => User::find(Auth::id()),
        ]);
    }

    /**
     * Remove token and disconect user
     *
     * @return json 
     */
    public function logout(Request $request)
    {
        try {
            // If token is valid, drop token and disconect user.
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User disconnected'
            ]);
        } catch (JWTException $exception) {
            //Error chungo; very chungo.
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }


}
