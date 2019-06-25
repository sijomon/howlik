<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Larapen\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Larapen\Events\UserWasLogged' => [
            'App\Larapen\Listeners\UpdateUserLastLogin',
        ],
        'App\Larapen\Events\UserWasRegistered' => [
            'App\Larapen\Listeners\EmailWelcomeMessage',
        ],
        'App\Larapen\Events\BusinessWasPosted' => [
            'App\Larapen\Listeners\EmailBusinessActivation',
        ],
        'App\Larapen\Events\MessageWasSent' => [
            'App\Larapen\Listeners\EmailMessageToAdvertiser',
        ],
        'App\Larapen\Events\ReportAbuseWasSent' => [
            'App\Larapen\Listeners\EmailReportAbuse',
        ],
        'App\Larapen\Events\BusinessWasVisited' => [
            'App\Larapen\Listeners\UpdateTheBusinessCounter',
        ],
        'App\Larapen\Events\ContactFormWasSent' => [
            'App\Larapen\Listeners\EmailFromContactUs',
        ],
        'App\Larapen\Events\BusinessWasDeleted' => [
            'App\Larapen\Listeners\EmailBusinessDeleteConfirmation',
        ],
        'App\Larapen\Events\BusinessWillBeDeleted' => [
            'App\Larapen\Listeners\EmailBusinessDeleteAlert',
        ],
		'App\Larapen\Events\EventWasVisited' => [
            'App\Larapen\Listeners\UpdateTheEventCounter',
        ],
		'App\Larapen\Events\SendMessageToFriend' => [
            'App\Larapen\Listeners\EmailMessageToFriend',
        ],
		'App\Larapen\Events\SendMessage' => [
            'App\Larapen\Listeners\SendMailFired',
        ],
		'App\Larapen\Events\SendInvitaion' => [
            'App\Larapen\Listeners\SendInvitationFired',
        ],
    ];
    
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    //protected $subscribe = [];
    
    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
        
        //
    }
}
