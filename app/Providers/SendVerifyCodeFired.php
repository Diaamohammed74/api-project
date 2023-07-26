<?php

namespace App\Providers;

use App\Providers\SendVerifyCode;
use App\Mail\SendVerificationCode;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerifyCodeFired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendVerifyCode $event): void
    {
        // dd($event->user->email);
        $user=$event->user;
        Mail::to($user->email)->send(new SendVerificationCode('Email Verfication',$user->email_code));
    }
}
