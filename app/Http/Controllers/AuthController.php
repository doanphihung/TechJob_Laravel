<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function employerRegister(Request $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->role = 2;
        $user->save();
        if($user) {
            $company_acronym =   strtoupper(substr(preg_replace('/\s+/', '', $request->name), 0, 3));
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
        $email = $request->email;
        $password = $request->password;
        $data = [
            'email' => $email,
            'password' => $password
        ];
        if (Auth::attempt($data)){
            return response()->json(['status'=>'success'],201);
        }else{
            return response()->json(['status'=>'failed'],500);
        }

    }
}
