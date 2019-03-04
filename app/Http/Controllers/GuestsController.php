<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class GuestsController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $data = User::where('email', $credentials['email'])->get()->toArray();
        if(count($data) > 0){
            if (! $token = auth()->attempt($credentials)) {
                //return response()->json(['error' => 'Unauthorized'], 401);
                return response()->json([
                    'code' => FAILED,
                    'message' => 'Login Fail',
                    'data' => ''
                ]);
            }
            elseif ($data[0]['type'] != 'user') {
                //return response()->json(['error' => 'Unauthorized'], 401);    
                return response()->json([
                    'code' => FAILED,
                    'message' => 'You are not authorize person',
                    'data' => ''
                ]);       
            }
        }
        else {
            return response()->json([
                'code' => FAILED,
                'message' => 'Incorrect Email or Password',
                'data' => ''
            ]);
        }
       /* return response()->json([
            'message' => 'I am admin',
            //'expires_in' => auth()->factory()->getTTL() * 60
        ]);*/
        /*return response()->json([
            'code' => SUCCESS,
            'message' => 'Guest Login',
            'data' => $data
        ]);*/
        
        return $this->respondWithToken($token,$data);
        
        
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$data)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'code' => SUCCESS,
            'message' => 'Guest Login',
            'data' => $data
            //'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function payload()
    {
    	return auth()->payload();
    }
}
