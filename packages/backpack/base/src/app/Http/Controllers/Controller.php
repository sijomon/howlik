<?php

namespace Larapen\Base\app\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        /* SET CONFIG */
        // Auth
        config(['auth.passwords.users.email' => 'vendor.backpack.base.auth.emails.password']);
        // Mail
        config(['mail.driver' => env('MAIL_DRIVER', config('settings.mail_driver'))]);
        config(['mail.host' => env('MAIL_HOST', config('settings.mail_host'))]);
        config(['mail.port' => env('MAIL_PORT', config('settings.mail_port'))]);
        config(['mail.encryption' => env('MAIL_ENCRYPTION', config('settings.mail_encryption'))]);
        config(['mail.username' => env('MAIL_USERNAME', config('settings.mail_username'))]);
        config(['mail.password' => env('MAIL_PASSWORD', config('settings.mail_password'))]);
        config(['mail.from.address' => config('settings.app_email')]);
        config(['mail.from.name' => config('settings.app_name')]);
        // Mailgun
        config(['services.mailgun.domain' => env('MAILGUN_DOMAIN', config('settings.mailgun_domain'))]);
        config(['services.mailgun.secret' => env('MAILGUN_SECRET', config('settings.mailgun_secret'))]);
        // Mandrill
        config(['services.mandrill.secret' => env('MANDRILL_SECRET', config('settings.mandrill_secret'))]);
        // Amazon SES
        config(['services.ses.key' => env('SES_KEY', config('settings.ses_key'))]);
        config(['services.ses.secret' => env('SES_SECRET', config('settings.ses_secret'))]);
        config(['services.ses.region' => env('SES_REGION', config('settings.ses_region'))]);
    }
}
