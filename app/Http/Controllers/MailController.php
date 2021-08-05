<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function forwardJob(Request $request, $id)
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
    }


}
