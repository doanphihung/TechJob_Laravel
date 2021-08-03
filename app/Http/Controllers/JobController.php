<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $jobs = Job::with('company', 'category', 'city')->where('status', '=', '1')->orderBy('id', 'desc')->get();
        return response()->json($jobs, 200);
    }

    public function findById($id): \Illuminate\Http\JsonResponse
    {
        $job = Job::with('city', 'category', 'company')->find($id);
        $company = Company::with(['user', 'city', 'jobs'])->where('id', '=', $job->company_id)->first();
        return response()->json(['job' => $job,
                                 'company' => $company], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $job = Job::find($id);
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
            if (!$request->status) {
                $job->status = NULL;
            } else {
                $job->status = 1;
            }
            $job->save();
            DB::commit();
            return response()->json(['message' => 'Chỉnh sửa tin tuyển dụng thành công!',
                'status' => 1], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Chỉnh sửa tin tuyển dụng thất bại!',
                'status' => 0], 500);
        }
    }

    public function searchByKeyWord(Request $request): \Illuminate\Http\JsonResponse
    {
        $title = $request->title;
        $jobs = Job::with('company', 'category', 'city')
            ->where('title', 'LIKE', '%' . $title . '%')->get();
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }

    public function searchByCity(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $title = $request->title;
        $city = City::with('jobs')->find($id);
        $jobs = $city->jobs;
        $jobs = $jobs->intersect(Job::with('company', 'category', 'city')
            ->where('title', 'LIKE', '%' . $title . '%')->get());
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }

    public function searchByCategory($id): \Illuminate\Http\JsonResponse
    {
        $jobs = Category::with('jobs')->find($id)->jobs;
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }


}
