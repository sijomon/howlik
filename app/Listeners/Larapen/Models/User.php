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

use App\Larapen\Scopes\ActiveScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    protected $appends = ['created_at_ta'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_key',
        'country_code',
        'user_type_id',
        'gender_id',
        'name',
        'about',
        'photo',
        'cover',
        'phone',
        'phone_hidden',
        'email',
        'password',
        'remember_token',
        'is_admin',
        'comments_enabled',
        'receive_newsletter',
        'receive_advice',
		'find_friends',
		'direct_messages',
        'ip_addr',
        'provider',
        'provider_id',
        'activation_token',
        'active',
        'blocked',
        'closed',
		 'gcm_token',    
        'ios_token',
		'device',
		'profile_view',
		'email_notifications',
		'apikey_updated_at'
    ];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'last_login_at', 'deleted_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new ActiveScope());
        
        // before delete() method call this
        static::deleting(function ($user) {
            // Delete all user's ads with depencies
            if ($user->ads) {
                foreach ($user->ads as $item) {
                    $ad = Ad::find($item->id);
                    $ad->delete();
                }
            }
            
            // Delete all user's messages
            $user->messages()->delete();
            
            // Delete all favourite ads
            DB::table('saved_ads')->where('user_id', $user->id)->delete();
            
            // Delete all saved search
            $user->savedSearch()->delete();
        });
    }
    
    public function getActiveHtml()
    {
        if ($this->active == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function ads()
    {
        return $this->hasMany('App\Larapen\Models\Ad', 'user_id');
    }
    
    public function country()
    {
        return $this->belongsTo('App\Larapen\Models\Country', 'country_code');
    }
    
    public function gender()
    {
        return $this->belongsTo('App\Larapen\Models\Gender', 'gender_id');
    }
    
    public function messages()
    {
        return $this->hasManyThrough('App\Larapen\Models\Message', 'App\Larapen\Models\Ad', 'user_id', 'ad_id');
    }
    
    public function savedAds()
    {
        return $this->belongsToMany('App\Larapen\Models\Ad', 'saved_ads', 'user_id', 'ad_id');
    }
    
    public function savedSearch()
    {
        return $this->hasMany('App\Larapen\Models\SavedSearch', 'user_id');
    }
    
    public function userType()
    {
        return $this->belongsTo('App\Larapen\Models\UserType', 'user_type_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
	public function getNameAttribute($value)
    {
        return $value;
    }
	
    public function getCreatedAtAttribute($value)
    {
        $value = \Carbon\Carbon::parse($value);
        if (session('time_zone')) {
            $value->timezone(session('time_zone'));
        }
        //echo $value->format('l d F Y H:i:s').'<hr>'; exit();
        //echo $value->formatLocalized('%A %d %B %Y %H:%M').'<hr>'; exit(); // Multi-language

        return $value;
    }
    
    public function getUpdatedAtAttribute($value)
    {
        $value = \Carbon\Carbon::parse($value);
        if (session('time_zone')) {
            $value->timezone(session('time_zone'));
        }

        return $value;
    }
    
    public function getLastLoginAtAttribute($value)
    {
        $value = \Carbon\Carbon::parse($value);
        if (session('time_zone')) {
            $value->timezone(session('time_zone'));
        }

        return $value;
    }
    
    public function getDeletedAtAttribute($value)
    {
        $value = \Carbon\Carbon::parse($value);
        if (session('time_zone')) {
            $value->timezone(session('time_zone'));
        }

        return $value;
    }
    
    public function getCreatedAtTaAttribute($value)
    {
        if (!isset($this->attributes['created_at'])) {
            return null;
        }
		if (is_null($this->attributes['created_at'])) {
			return null;
		}

        $value = \Carbon\Carbon::parse($this->attributes['created_at']);
        if (session('time_zone')) {
            $value->timezone(session('time_zone'));
        }
        $value = time_ago($value, session('time_zone'), session('language_code'));

        return $value;
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
