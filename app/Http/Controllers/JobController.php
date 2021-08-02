<?php

namespace App\Http\Controllers;

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
        $job = Job::find($id);
        return response()->json($job, 200);

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
            } else{
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
}
