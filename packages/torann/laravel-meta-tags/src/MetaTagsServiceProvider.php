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

namespace Larapen\LaravelMetaTags;

use Torann\LaravelMetaTags\MetaTagsServiceProvider as TorannMetaTagsServiceProvider;

class MetaTagsServiceProvider extends TorannMetaTagsServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['metatag'] = $this->app->share(function ($app) {
            return new MetaTag($app['request'], $app['config']['meta-tags'], $app['config']->get('app.locale'));
        });
    }
}
