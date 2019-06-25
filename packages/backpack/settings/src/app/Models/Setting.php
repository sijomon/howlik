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

namespace Larapen\Settings\app\Models;

use App\Larapen\Models\BaseModel;
use Larapen\CRUD\CrudTrait;
use Illuminate\Support\Facades\Request;

class Setting extends BaseModel
{
    use CrudTrait;
    
    protected $table = 'settings';
    protected $guarded = ['id'];
    protected $fillable = ['value', 'lft', 'rgt', 'depth'];
    
    public function getLogoHtml()
    {
        if ($this->key == 'app_logo') {
            if ($this->value == '') {
                $logo = 'images/logo.png';
            } else {
                $logoFilename = last(explode('/', $this->value));
                $logo = 'pic/x/cache/logo/' . $logoFilename;
            }
            
            return '<img src="' . url($logo) . '" alt="' . $this->value . '"><br>[<a href="/admin/setting/' . $this->id . '/edit">Edit</a>]';
        } else {
            return $this->value;
        }
    }
    
    public function getValueAttribute($value)
    {
        if (Request::segment(1) == 'admin') {
            $hiddenValues = [
                'recaptcha_public_key',
                'recaptcha_private_key',
                'mail_password',
                'mailgun_secret',
                'mandrill_secret',
                'ses_key',
                'ses_secret',
                'sparkpost_secret',
                'stripe_secret',
                'paypal_username',
                'paypal_password',
                'paypal_signature',
                'facebook_client_id',
                'facebook_client_secret',
                'google_client_id',
                'google_client_secret',
                'google_maps_key',
                'twitter_client_id',
                'twitter_client_secret',
            ];
            
            if (in_array($this->attributes['key'], $hiddenValues)) {
                $value = '************************';
            } else {
                if (str_contains($this->attributes['field'], 'checkbox')) {
                    if (Request::segment(4) != 'edit') {
                        if ($value == 1) {
                            $value = '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                        } else {
                            $value = '<i class="fa fa-square-o" aria-hidden="true"></i>';
                        }
                    }
                }
            }
            
            return $value;
        } else {
            return $value;
        }
    }
}
