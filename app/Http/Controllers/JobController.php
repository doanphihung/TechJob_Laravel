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
        // $jobs=Job::all();
        return response()->json($jobs, 200);
    }

    public function getFirstFiveJob(): \Illuminate\Http\JsonResponse
    {
        $jobs = Job::with('company', 'category', 'city')->where('status', '=', '1')->orderBy('id', 'desc')->take(5)->get();
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

    public function searchWithoutCity(Request $request): \Illuminate\Http\JsonResponse
    {
        $keyword = $request->keyword;
        $language = $request->language;
        $jobs = Job::with('company', 'category', 'city')
            ->where('status', '=', 1)
            ->where('title', 'LIKE', '%' . $keyword . '%')
            ->where('language', 'LIKE', '%' . $language . '%')
            ->get();
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }

    public function searchWithCity(Request $request): \Illuminate\Http\JsonResponse
    {
        $keyword = $request->keyword;
        $language = $request->language;
        $city = (int)$request->city;
        $jobs = Job::with('company', 'category', 'city')
            ->where('status', '=', 1)
            ->where('title', 'LIKE', '%' . $keyword . '%')
            ->where('language', 'LIKE', '%' . $language . '%')
            ->get();
        $jobs = $jobs->intersect(City::with('jobs')->find($city)->jobs);
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }


    public function searchByCategory($id): \Illuminate\Http\JsonResponse
    {
        $jobs = Job::with('company', 'category', 'city')
            ->where('status', '=', 1)
            ->get();
        $jobs = $jobs->intersect(Category::with('jobs')->find($id)->jobs);
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }

    public function searchByCompany(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyName = $request->companyKeyword;
        $companyID = Company::where('name', 'LIKE', '%' . $companyName . '%')
            ->pluck('id')
            ->all();
        $jobs = Job::with('company', 'category', 'city')
            ->where('status','=',1)
            ->whereIn('company_id', $companyID)->get();
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }

    public function searchBySalary(Request $request): \Illuminate\Http\JsonResponse
    {
        $from_salary= (+$request->from_salary)*1000000;
        $to_salary= (+$request->to_salary)*1000000;
        if (!$from_salary){
            $jobs = Job::with('company', 'category', 'city')
                ->where('status', '=', 1)
                ->where('to_salary','<=',$to_salary)
                ->get();
        }elseif (!$to_salary){
            $jobs = Job::with('company', 'category', 'city')
                ->where('status', '=', 1)
                ->where('from_salary','>=',$from_salary)
                ->get();
        }else{
            $jobs = Job::with('company', 'category', 'city')
                ->where('status', '=', 1)
                ->where('from_salary','>=',$from_salary)
                ->where('to_salary','<=',$to_salary)
                ->get();
        }
        return response()->json([
            'message' => 'search success',
            'jobs' => $jobs,
        ], 200);
    }
}
