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

namespace App\Larapen\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Large implements FilterInterface
{
    /**
     * Size of filter effects
     *
     * @var integer
     */
    private $sizeW = 900;
    private $sizeH = null;
    
    /**
     * JPEG Quality of filter effects
     *
     * @var integer
     */
    private $quality = 90;
    
    /**
     * Applies filter effects to given image
     *
     * @param  Intervention\Image\Image $image
     * @return Intervention\Image\Image
     */
    public function applyFilter(Image $image)
    {
        return $image->resize($this->sizeW, $this->sizeH, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', $this->quality);
    }
}
