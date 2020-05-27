<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;

class SocialController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 주어진 provider에 대하여 소셜 응답을 처리합니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    public function execute(Request $request, string $provider)
    {
        if (! array_key_exists($provider, config('services'))) {
            return $this->sendNotSupportedResponse($provider);
        }

        if (! $request->has('code')) {
            return $this->redirectToProvider($provider);
        }

        return $this->handleProviderCallback($request, $provider);
    }

    /**
     * 사용자를 주어진 공급자의 OAuth 서비스로 리디렉션합니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 소셜에서 인증을 받은 후 응답입니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    protected function handleProviderCallback(Request $request, string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        if ($user = User::where('email', $socialUser->getEmail())->first()) {
            $this->guard()->login($user, true);

            return $this->sendLoginResponse($request);
        }

        return $this->register($request, $socialUser);
    }

    /**
     * 주어진 소셜 회원을 응용 프로그램에 등록합니다.
     *
     * @param Request    $request
     * @param SocialUser $socialUser
     * @return mixed
     */
    protected function register(Request $request, SocialUser $socialUser)
    {
        event(new Registered($user = User::create($socialUser->getRaw())));

        $user->email_verified_at = Date::now();
        $user->remember_token = Str::random(60);
        $user->save();

        $this->guard()->login($user, true);

        return $this->sendLoginResponse($request);
    }

    /**
     * 사용자 인증을 받았습니다.
     *
     * @param Request $request
     * @param User    $user
     */
    protected function authenticated(Request $request, User $user): void
    {
        flash()->success(__('auth.welcome', ['name' => $user->name]));
    }

    /**
     * 지원하지 않는 소셜 공급자에 대한 응답입니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function sendNotSupportedResponse(string $provider): RedirectResponse
    {
        flash()->error(trans('auth.social.not_supported', ['provider' => $provider]));

        return back();
    }
}