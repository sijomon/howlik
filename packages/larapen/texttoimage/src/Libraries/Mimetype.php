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

namespace Larapen\TextToImage\Libraries;

class Mimetype
{
    public static function getMimetype($type)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                return 'image/jpeg';
            case IMAGETYPE_GIF:
                return 'image/gif';
            case IMAGETYPE_PNG:
                return 'image/png';
            default:
                return null;
        }
    }
}
