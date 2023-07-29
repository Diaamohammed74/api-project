<?php

namespace Modules\Users\Providers;

use Illuminate\Support\Facades\Mail;
use Modules\Users\Providers\SendVerifyCode;
use Modules\Users\Http\Mail\SendVerificationCode;
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
        $user=$event->user;
        Mail::to($user->email)->queue(new SendVerificationCode('Email Verfication',$user->email_code));
    }
}
