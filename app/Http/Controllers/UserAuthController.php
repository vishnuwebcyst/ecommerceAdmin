<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use App\Mail\forgotMail;
 

class UserAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgotPassword', 'resetPassword']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email|not_in:admin,admin@gmail.com',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Email or Password is wrong'], 401);
        }

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return response()->json(['error' => 'Not Found'], 401);
        }
        $credentials = request(['email', 'password']);

        if (Hash::check($request->password, $user->password)) {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => false, 'error' => 'Email or Password is wrong'], 401);
            }

            return response()->json(['status' => true, 'token' => $token, 'message' => 'User Login Successful', 'user' => $user], 200);
        }

        return response()->json(['status' => false, 'error' => 'Email or Password is wrong'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->first()], 400);
        }


        $user = User::where("uid", $request->spId)->first();
        if ($request->spId == "admin") {
            return response()->json(['status' => false, 'error' => "Invalid Sponser Id"], 400);
        }


        $uid = mt_rand(10000, 99999);

        $whilee = true;
        while ($whilee == true) {
            $user = User::where("uid", $uid)->first();
            $uid = 'PPP' . mt_rand(10000, 99999);
            if ($user == null) {
                $uid = $uid;
                $whilee = false;
                break;
                exit;
            }
        }


        \Log::info($request->all());
        \Log::info($uid);
        $password = Hash::make($request->password);

        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'uid' => $uid,
            'spid' => $request->spId,
            'password' => $password,
            'show_pass' => $request->password,
        ]);

        $token = JWTAuth::attempt(request(['email', 'password']));

        return response()->json(['status' => true, 'token' => $token, 'message' => 'User Registered Successfully', 'user' => User::where('email', $request->email)->first()], 201);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => ['email' => 'Invalid Email']], 422);
        }

        $user = User::where('email', $request->email)->first();
        $token = Str::random(15);
        $link = env('SPA_LINK') . '/reset-password/' . $token;

        $user->update(['reset_token' => $token]);

        Mail::to($request->email)->send(new ForgotPasswordMail($user->name, $link));

        return response()->json(['message' => 'An Email has sent to your email address with link to reset your password']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|exists:users,email',
            'token' => 'required|exists:users,reset_token',
            'password' => 'required|confirmed|min:6|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $passwordToken = User::where('reset_token', $request->token)->first();

        if (empty($passwordToken)) {
            return response()->json(['error' => 'Invalid Request'], 400);
        }
        if ($request->token !== $passwordToken->reset_token) {
            return response()->json(['error' => 'Token doesn\'t matched'], 400);
        }

        User::where('email', $passwordToken->email)->update(['password' => Hash::make($request->password), 'reset_token' => '']);

        return response()->json(['message' => 'Password successfully reset']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['status' => true, 'user' => JWTAuth::user()]);
    }

    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::logout();

        return response()->json(['status' => true, 'message' => 'Successfully logged out']);
    }
}
