<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordAuthRequest;
use App\Http\Requests\DeleteUserAuthRequest;
use App\Http\Requests\GetUserAuthRequest;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Requests\UpdateUserAuthRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        //Not used
    }

    /**
    * Returns the current logged user
    */
    public function getUser(GetUserAuthRequest $request)
    {
        return response()->json(User::findOrFail($request->id));
    }

    /**
     * Change the password of current user
     * 
     */
    public function changePassword(ChangePasswordAuthRequest $request)
    {
        $user = User::findOrFail($request->id);
        $user->password = bcrypt($request->password);        
        $user->save();
        //$this->guard()->logout();

        return response()->json(['success' => true]);
    }

    /**
     * Update user details
     */
    public function update(UpdateUserAuthRequest $request)
    {
        $user = User::findOrFail($request->id);
        if($request->has('name'))
            $user->name = $request->name;
        if($request->has('address'))
            $user->address = $request->address;

        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Delete a user
     */
    public function delete(DeleteUserAuthRequest $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        //$this->guard()->logout();

        return response()->json(['success' => true]);
    }

    /**
     * Register a new user
     */
    public function register(RegisterAuthRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Create JWT token for a user using email and password as credentials
     */
    public function login(LoginAuthRequest $request)
    {
        $input = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($input)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }


    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
