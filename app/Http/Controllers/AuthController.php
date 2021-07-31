<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function employerRegister(Request $request)
    {
        $oldUser = User::where('email', $request->email)->first();
        if ($oldUser) {
            return response()->json(['message' => 'Tài khoản đã tồn tại!'], 409);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 2;
        $user->save();
        if ($user) {
            $company_acronym = strtoupper(substr(preg_replace('/\s+/', '', $request->name), 0, 3));
            $company = new Company();
            $company->acronym = $company_acronym;
            $company->city_id = $request->city_id;
            $company->user_id = $user->id;
            $company->employees = $request->employees;
            $company->map_link = $request->map_link;
            $company->save();
            $company->code = $company_acronym . $company->id . rand(1000, 9999);
            $company->save();
            return response()->json(['message' => 'Register successfully!'], 201);
        }
        return response()->json(['message' => 'Registration failed!'], 500);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            if (!JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Email hoặc mật khẩu không chính xác!',
                    'status' => 0]);

            }
        } catch (JWTException $JWTException) {
            return response()->json(['message' => 'Failed_to_create_token'], 500);
        }

        $user = auth()->user();
        $response['token'] = auth()->claims([
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_id' => $user->id,
            'user_role' => $user->role,
        ])->attempt($credentials);

        $response['message'] = 'Welcome ' . $user->name;
        $response['status'] = 1;
        return response()->json($response, 200);
    }

}
