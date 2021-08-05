<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '[TechJob]' . $this->job->company->name . '-' . $this->job->title;
//        return $this->subject('TechJob')->view('mail.forward-job-mail', ['job' => $this->job]);
        return $this->from('hungq394@gmail.com', 'TechJob')
            ->subject($subject)
            ->markdown('mail.forward-job-mail')
            ->with([ 'job'=> $this->job]);
    }
}
