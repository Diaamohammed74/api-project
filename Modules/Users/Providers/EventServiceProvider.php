<?php

namespace Modules\Users\Providers;

use Modules\Users\Providers\SendVerifyCode;
use Modules\Users\Providers\SendVerifyCodeFired;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendVerifyCode::class => [
            SendVerifyCodeFired::class,
        ],
    ];
}