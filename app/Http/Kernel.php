<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
   
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\UserOnlineCheck::class,
            \HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'CaptchaCheck' => \App\Http\Middleware\CaptchaCheck::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'CheckBanned' => \App\Http\Middleware\CheckBanned::class,
        'roles' => \App\Http\Middleware\Roles::class,
        'ActivatingUser' => \App\Http\Middleware\ActivatingUser::class,
        'ActivatingGuest' => \App\Http\Middleware\ActivatingGuest::class,
        'AuthGuestCheck' => \App\Http\Middleware\AuthGuestCheck::class,
        'ReCaptchaValidated' => \App\Http\Middleware\RecaptchaVerify::class,
        'OnlineHistory' => \App\Http\Middleware\OnlineHistoryMiddleware::class,
        'GuestOnlineCheck' =>  \App\Http\Middleware\GuestOnlineCheck::class,
        'Tracking' =>   \App\Http\Middleware\PageTrackingMiddleware::class,
        'CheckPM' =>   \App\Http\Middleware\CheckPM::class,
        'RequireAbsen' =>   \App\Http\Middleware\RequireAbsen::class,

    ];
}
