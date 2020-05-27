<?php

namespace App\Listeners\SocialiteProviders\Naver;

use App\Events\SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NaverExtendSocialite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SocialiteWasCalled  $event
     * @return void
     */
    public function handle(SocialiteWasCalled $event)
    {
        //
    }
}
