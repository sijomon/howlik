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

namespace Larapen\LaravelInstaller\Controllers;

use App\Http\Requests;
use RachidLaasri\LaravelInstaller\Helpers\PermissionsChecker;
use RachidLaasri\LaravelInstaller\Controllers\PermissionsController as RachidLaasriPermissionsController;

class PermissionsController extends RachidLaasriPermissionsController
{
    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @param PermissionsChecker $checker
     */
    public function __construct(PermissionsChecker $checker)
    {
        parent::__construct($checker);

        // Fix unknown public folder (for LaravelInstaller)
        $user_public_folder = last(explode(DIRECTORY_SEPARATOR, public_path()));
        config(['installer.permissions.' . $user_public_folder . '/uploads/' => '775']);
    }
}
