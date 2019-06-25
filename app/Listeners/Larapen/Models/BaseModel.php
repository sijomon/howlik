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

namespace App\Larapen\Models;

use Illuminate\Database\Eloquent\Model;
use Prologue\Alerts\Facades\Alert;
use Auth;
use Illuminate\Support\Facades\Request;
use Larapen\CRUD\CrudTrait;

class BaseModel extends Model
{
    use CrudTrait;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    
    // ...
}
