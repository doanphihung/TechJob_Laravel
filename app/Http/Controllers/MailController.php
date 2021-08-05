<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function forwardJob(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {

            $toEmail = $request->email;
            $job = Job::with('company', 'city', 'category')->find($id);
            $data = [
                'job' => $job
            ];
            $subject = '[Tech]' . $job->company->name . '-' . $job->title;
            Mail::send('mail.forward-job-mail', $data, function ($message) use ($subject, $toEmail) {
                $message->to($toEmail)->subject($subject);
                $message->from('hungq394@gmail.com', 'TechJob');
            });
            return response()->json(['message' => 'Gửi Mail thành công!'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Gửi Mail thất bại!'], 500);
        }

//        $job = Job::with('company', 'city', 'category')->find($id);
//        Mail::to($request->email)->queue(new SendMail($job));
//        return response()->json(['message' => 'Gửi mail thành công!']);


    }

    public function verifyEmail($user)
    {
            $toEmail = $user->email;
            $confirmation_code = $user->confirmation_code;
            $data = [
                'confirmation_code' => $confirmation_code,
                'user' => $user,
            ];
            $subject = '[TechJob] - Xác thực Email';
            Mail::send('mail.confirm-email', $data, function ($message) use ($subject, $toEmail) {
                $message->to($toEmail)->subject($subject);
                $message->from('hungq394@gmail.com', 'TechJob');
            });
    }


}
