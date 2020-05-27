<?php

namespace App\Listeners\SocialiteProviders\Kakao;

use App\Events\SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KakaoExtendSocialite
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
