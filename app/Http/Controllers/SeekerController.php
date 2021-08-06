<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\Seeker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SeekerController extends Controller
{
    public function details($id)
    {
        $seeker = Seeker::with('user')->where('user_id', '=', $id)->first();
        return response()->json($seeker, 200);
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
                    Storage::delete('public/seeker/' . $imageCurrent);
                }
                $newImageName = time() . '-' . $request->name . "." . $image->getClientOriginalExtension();
                $request->file('image')->storeAs('public/seeker', $newImageName);
                $user->image = $newImageName;
            }
            $user->save();
            $seeker = Seeker::where('user_id', '=', $id)->first();
            $seeker->phone = $request->phone;
            $seeker->gender = $request->gender;
            $seeker->birthday = $request->birthday;
            $seeker->address = $request->address;
            $seeker->image = $user->image;
            $seeker->user_id = $id;
            $seeker->save();
            DB::commit();
            return response()->json(['message' => 'Chỉnh sửa hồ sơ thành công!',
                'status' => 1], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Chỉnh sửa hồ sơ thất bại!',
                'status' => 0], 500);
        }
    }

    public function apply($id_seeker, $id_job)
    {
        try {
            $seeker = Seeker::where('user_id', $id_seeker)->first();
            $jobs = $seeker->jobs;
            $arrayIdJobs= [];
            if ($jobs) {
                foreach ($jobs as $job) {
                    $arrayIdJobs[] = $job->id;
                }
                if (in_array($id_job, $arrayIdJobs)) {
                    return response()->json(['message' => 'Bạn đã ứng tuyển công việc này!',
                        'status' => 2], 200);
                }
            }
            $seeker->jobs()->attach($id_job);
            return response()->json(['message' => 'Nộp CV thành công!',
                                      'status' => 1], 200);
        } catch (\Exception $exception) {
//            return $exception->getMessage();
            return response()->json(['message' => 'Something wrong!',
                                     'status' => 0], 500);
        }
    }

    public function getAllJobsApplied($id) {
        $seeker = Seeker::where('user_id', $id)->first();
        $jobs = $seeker->jobs;
        return response()->json($jobs, 200);
    }
}
