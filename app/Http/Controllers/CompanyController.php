<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;

class CompanyController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $companies = Company::with('user', 'city')->where('status', '=', '1')->get();
        return response()->json($companies, 200);
    }

    public function details($id): \Illuminate\Http\JsonResponse
    {
        $company = Company::with(['user', 'city', 'jobs'])->where('user_id', '=', $id)->first();
        $jobs = Job::with(['city', 'category'])->where('company_id', $company->id)->orderBy('id', 'desc')->get();
        return response()->json(['company' => $company,
            'jobs' => $jobs], 200);
    }

    public function listJob($id): \Illuminate\Http\JsonResponse
    {
        $jobs = Job::with(['city', 'category'])->where('company_id', $id)->orderBy('id', 'desc')->get();
        return response()->json($jobs, 200);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $image = $request->image;
            if ($request->hasFile('image')) {
                $imageCurrent = $user->image;
                if ($imageCurrent) {
                    Storage::delete('public/company/' . $imageCurrent);
                }
                $newImageName = time() . '-' . $request->name . "." . $image->getClientOriginalExtension();
                $request->file('image')->storeAs('public/company', $newImageName);
                $user->image = $newImageName;
            }
            $user->save();
            $company = Company::where('user_id', '=', $id)->first();
            $company->name = $user->name;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->description = $request->description;
            $company->employees = $request->employees;
            $company->facebook = $request->facebook;
            $company->map_link = $request->map_link;
            $company->image = $user->image;
            $company->save();
            DB::commit();
            return response()->json(['message' => 'Chỉnh sửa thành công!',
                'status' => 1], 200);
        } catch (JWTException $JWTException) {
            DB::rollBack();
            return response()->json(['message' => 'Chỉnh sửa thất bại!',
                'status' => 0], 500);
        }

    }

    public function postJob(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $company = Company::where('user_id', '=', $id)->first();
            $job = new Job();
            $job->title = $request->title;
            $job->language = $request->language;
            $job->from_salary = $request->from_salary;
            $job->to_salary = $request->to_salary;
            $job->experience = $request->experience;
            $job->expire = $request->expire;
            $job->description = $request->description;
            $job->type_of_job = $request->type_of_job;
            $job->position = $request->position;
            $job->upto = $request->upto;
            $job->city_id = $request->city_id;
            $job->category_id = $request->category_id;
            $job->company_id = $company->id;
            $job->save();
            DB::commit();
            return response()->json(['message' => 'Thêm tin tuyển dụng thành công!',
                'status' => 1], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Thêm tin tuyển dụng thất bại!',
                'status' => 0], 500);
        }
    }
}
