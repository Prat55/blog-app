<?php

namespace App\Jobs;

use App\Mail\RegisterUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRegisterUserMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $userMail;
    public $mailData;

    /**
     * Create a new job instance.
     */
    public function __construct($userMail, $mailData)
    {
        $this->userMail = $userMail;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email =  new RegisterUser($this->mailData);
        Mail::to($this->userMail)->send($email);
    }
}
