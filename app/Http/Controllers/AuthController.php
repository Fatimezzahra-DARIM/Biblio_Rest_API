<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register', 'resetPassword','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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
    //register
    public function register()
    {
        try {
                request()->validate([
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required|confirmed|min:6'
                ]);

                $user = new User;
                $user->name = request('name');
                $user->email = request('email');
                $user->password = Hash::make(request('password'));
                $user->save();

                // User::create([
                //     'name' => request('name'),
                //     'email' => request('email'),
                //     'password' => Hash::make(request('password'))
                // ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json(['success' => 'account has been created successfully']);
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
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    //Reset Password 
    public function resetPassword()
    {
        request()->validate(['email' => 'required|email|exists:users']);
        $token = Str::random(64);

        $email = request('email');

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d')
        ]);

        Mail::send([], [], function ($message) use ($email, $token) {
            $message->to($email);
            $message->subject('Reset Password');
            $message->text(
                "please click on the link below to reset your password. \n
                http://127.0.0.1:8000/api/auth/reset?email=" . $email . "&token=" . $token
            );
        });

        return response()->json(['message' => 'Success send']);
    }

    public function reset()
    {
        request()->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
        ->where([
            'email' => request('email'),
            'token' => request('token')
        ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['error' => 'Invalid token or email!']);
        }

        User::where('email', request('email'))
        ->update(['password' => Hash::make(request('password'))]);

        DB::table('password_reset_tokens')->where(['email' => request('email')])->delete();

        return response()->json(['message' => 'Your password has been changed!']);
    }
}
