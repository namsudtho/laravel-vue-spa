<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use JWTException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password'  => 'required|min:3|max:255',
        ]);

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }

        $client = new Client();
        $result = $client->post(env('BOONRAWD_URL'), [
            'form_params' => [
                'system_id' => env('BOONRAWD_SECRET'),
                'username' => $request->username,
                'password' => base64_encode($request->password)
            ]
        ]);
        $response = json_decode($result->getBody());

        if ($response->result === 'Success') {
            $groups = collect((array)$response->group);
            $groups->shift();
            $role = $groups->search(env('BOONRAWD_ROLE_ADMIN'));

            $user = User::updateOrCreate([
                'username' => $request->username
            ], [
                'empid' => $response->empid,
                'name' => $response->display_name,
                'email' => $response->email,
                'role' => !!$role ? (User::ADMIN_ROLE) : (User::DEFAULT_ROLE),
            ]);

            if ($token = JWTAuth::fromUser($user)) {
                return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
            }
        }
        return response()->json(['status' => 'error', 'errors' => 'Username or password is incorrect'], 422);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['status' => 'success', 'msg' => 'Logged out Successfully.'], 200);
    }

    public function refresh()
    {
        if ($token = JWTAuth::refresh(JWTAuth::getToken())) {
            return response()->json(['status' => 'successs'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    public function user()
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }
}
