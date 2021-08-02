<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Seeker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function employerRegister(Request $request)
    {
        $oldEmail = User::where('email', $request->email)->first();
        if ($oldEmail) {
            return response()->json(['message' => 'Email đã tồn tại!',
                'status' => '0'], 200);
        }
        DB::beginTransaction();
        try {
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
                DB::commit();
                return response()->json(['message' => 'Đăng ký tài khoản thành công!',
                    'status' => '1'], 201);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Đăng ký tài khoản thất bại!'], 500);
        }

    }

    public function seekerRegister(Request $request): \Illuminate\Http\JsonResponse
    {
        $oldEmail = User::where('email', $request->email)->first();
        $oldPhoneSeeker = Seeker::where('phone', '=', $request->phone)->first();
        $oldPhoneCompany = Company::where('phone', '=', $request->phone)->first();
        if ($oldEmail) {
            return response()->json(['status' => '0',
                'message' => 'Email đã tồn tại']);
        }
        if ($oldPhoneSeeker == true || $oldPhoneCompany == true) {
            return response()->json(['status' => '2',
                'message' => 'Số điện thoại đã tồn tại!']);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->save();
            if ($user) {
                $seeker = new Seeker();
                $seeker->phone = $request->phone;
                $seeker->user_id = $user->id;
                $seeker->save();
                DB::commit();
                return response()->json(['message' => 'Đăng ký tài khoản thành công! Mời bạn đăng nhập để tiếp tục!',
                    'status' => '1'], 201);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Đăng ký tài khoản thất bại!'], 500);
        }
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
            'user_email' => $user->email,
            'user_id' => $user->id,
            'user_role' => $user->role,
        ])->attempt($credentials);

        $response['message'] = 'Chào mừng ' . $user->name . '!';
        $response['status'] = 1;
        return response()->json($response, 200);
    }
}
