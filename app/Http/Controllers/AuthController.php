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

class AuthController extends Controller
{
    /**
     * Register  a user 
     *
     * @return json with token
     */
    public function register(Request $request)
    {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateRegisterData();

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
     * Register  a Admin 
     *
     * @return json with token
     */
    public function registerAdmin(Request $request)
    {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateRegisterAdminData();

        // Make  new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
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
     * Register  a Agent 
     *
     * @return json with token
     */
    public function registerAgent(Request $request)
    {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateRegisterData();

        // Make  new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'agent',
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
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateLoginData();
        $credentials = $request->only('email', 'password');

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
            // JWTAuth::invalidate($request->bearerToken());
            JWTAuth::getToken(); // Ensures token is already loaded.
            $forever = true;
            JWTAuth::invalidate($forever);
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
