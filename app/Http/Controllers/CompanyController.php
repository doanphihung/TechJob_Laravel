<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class CompanyController extends Controller
{

    public function details($id) {
        $company = Company::with(['user','city', 'jobs'])->where('user_id', '=',$id)->first();
        return response()->json($company, 200);
    }

    public function update(Request $request, $id) {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $image = $request->image;
            if ($request->hasFile('image')) {
                $newImageName = time() . '-' . $request->name . "." . $image->getClientOriginalExtension();
                $request->file('image')->storeAs('public/company', $newImageName);
                $user->image = $newImageName;
            }
            $user->save();
            $company = Company::where('user_id', '=',$id)->first();
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->description = $request->description;
            $company->employees = $request->employees;
            $company->facebook = $request->facebook;
            $company->map_link = $request->map_link;
            $company->save();
            return response()->json(['message' => 'Chỉnh sửa thành công!',
                                    'status' => 1], 200);
        } catch (JWTException $JWTException) {
            return response()->json(['message' => 'Chỉnh sửa thất bại!',
                'status' => 0], 500);
        }

    }


}
