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
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class Ad extends BaseModel
{
    //use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ads';
    
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
        'country_code',
        'user_id',
        'category_id',
        'ad_type_id',
        'title',
        'description',
        'price',
        'negotiable',
        'resume',
        'new',
        'seller_name',
        'seller_email',
        'seller_phone',
        'seller_phone_hidden',
        'subadmin1_code',
		'city_id',
        'lat',
        'lon',
        'pack_id',
        'ip_addr',
        'visits',
        'activation_token',
        'active',
        'reviewed',
        'archived',
        'fb_profile',
        'partner'
    ];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function __construct(array $attributes = [])
    {
        // Added in release 1.1
        if (Schema::hasColumn($this->getTable(), 'address')) {
            $this->fillable[] = 'address';
        }

        parent::__construct($attributes);
    }
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new ActiveScope());
        static::addGlobalScope(new ReviewedScope());
        
        // DELETING - before delete() method call this
        static::deleting(function ($ad) {
            // Delete all messages
            $ad->messages()->delete();
            
            // Delete all entries by users in database
            //$ad->saveByUsers()->delete();
			// Replaced by vineeth
			$ad->savedAds()->delete();
            
            // Remove associated files
            if (is_numeric($ad->id)) {
                // Delete all pictures files
                if (!is_null($ad->pictures)) {
                    $picture_path = public_path() . '/uploads/pictures/';
                    if (File::exists($picture_path . strtolower($ad->country_code) . '/' . $ad->id)) {
                        File::deleteDirectory($picture_path . strtolower($ad->country_code) . '/' . $ad->id);
                    }
                }
                // Delete resume files (if exists)
                if (!is_null($ad->resume)) {
                    $resume_path = public_path() . '/uploads/resumes/';
                    if (File::exists($resume_path . strtolower($ad->country_code) . '/' . $ad->id)) {
                        File::deleteDirectory($resume_path . strtolower($ad->country_code) . '/' . $ad->id);
                    }
                }
            }
            
            // Delete all pictures entries in database
            $ad->pictures()->delete();
            
            // Delete the paymentof this Ad
            $ad->onePayment()->delete();
        });


        // UPDATING - before update() method call this
        static::updating(function ($ad) {
            // Get category
            $cat = Category::find(Input::get('parent'));
            if (!is_null($cat)) {
                // Pictures files cleanup by category type
                if (in_array($cat->type, ['job-offer', 'job-search'])) {
                    $pictures = Picture::where('ad_id', $ad->id)->get();
                    if (!is_null($pictures)) {
                        foreach ($pictures as $picture) {
                            $picture->delete();
                        }
                    }
                }

                // Resumes files cleanup by category type
                if (!in_array($cat->type, ['job-search'])) {
                    if (!empty($ad->resume)) {
                        $resume_path = public_path() . '/uploads/resumes/';
                        if (File::exists($resume_path . $ad->resume)) {
                            File::delete($resume_path . $ad->resume);
                        } else {
                            $resume_path = public_path() . '/';
                            if (File::exists($resume_path . $ad->resume)) {
                                File::delete($resume_path . $ad->resume);
                            }
                        }
                    }
                }
            }
        });
    }
    
    public function getTitleHtml()
    {
        return '<a href="/' . config('app.locale') . '/' . slugify($this->title) . '/' . $this->id . '.html" target="_blank">' . $this->title . '</a>';
    }
    
    public function getCityHtml()
    {
        if (isset($this->city) and !is_null($this->city)) {
            $lang = config('app.locale');
            $country_code = strtolower($this->city->country_code);
            $routes_text = trans('routes.t-search-location');
            $city_name = $this->city->name;
            $city_slug = slugify($city_name);
            $city_id = $this->city->id;
            
            return '<a href="/' . $lang . '/' . $country_code . '/' . $routes_text . '/' . $city_slug . '/' . $city_id . '" target="_blank">' . $city_name . '</a>';
        } else {
            return $this->city_id;
        }
    }
    
    public function getActiveHtml()
    {
        if ($this->active == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }

    public function getReviewedHtml()
    {
        if ($this->reviewed == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i><a href="reviews_det/'.$this->id.'"><span> Reviews</span></a>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }
	public function getRatingsHtml()
	{
		//return $this->id;
		$val = \DB::table('ratings')
							->select(\DB::raw('SUM(ratings) as total_sales'))
							->where('ads_id',$this->id)
							->get();
		$cnt = \DB::table('ratings')->select('ratings')
							->where('ads_id',$this->id)
							->count();
		//echo "<pre>";print_r($cnt);die;
		if($cnt != 0){
			$tab = [];
        foreach ($val as $entry) {
            $tab = $entry->total_sales/$cnt;
        }
		}
		 
        if(!empty($tab))
			return json_encode($tab);
		else
			return "No ratings yet";
		
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function adType()
    {
        return $this->belongsTo('App\Larapen\Models\AdType', 'ad_type_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Larapen\Models\Category', 'category_id');
    }
    
    public function city()
    {
        return $this->belongsTo('App\Larapen\Models\City', 'city_id');
    }
    
    public function country()
    {
        return $this->belongsTo('App\Larapen\Models\Country', 'country_code');
    }
    
    public function messages()
    {
        return $this->hasMany('App\Larapen\Models\Message', 'ad_id');
    }
    
    /*
    public function payment()
    {
        // @todo: Delete this method. Check if it's unused before.
        //return $this->belongsToMany('App\Larapen\Models\PaymentMethod', 'payments', 'ad_id', 'payment_method_id');
    }
    */
    public function onePayment()
    {
        return $this->hasOne('App\Larapen\Models\Payment', 'ad_id');
    }
    
    public function pictures()
    {
        return $this->hasMany('App\Larapen\Models\Picture');
    }
    
    public function saveByUsers()
    {
        return $this->belongsToMany('App\Larapen\Models\User', 'saved_ads', 'ad_id', 'user_id');
    }
	
	// Added by vineeth
	public function savedAds()
    {
        return $this->hasMany('App\Larapen\Models\SavedAd', 'ad_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Larapen\Models\User', 'user_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($builder)
    {
        if (Request::segment(1) == 'admin') {
            return $builder;
        }
    
        if (config('settings.ads_review_activation')) {
            return $builder->where('active', 1)->where('reviewed', 1)->where('archived', 0);
        } else {
            return $builder->where('active', 1)->where('archived', 0);
        }
    }
    
    public function scopeArchived($builder)
    {
        if (Request::segment(1) == 'admin') {
            return $builder;
        }
        
        return $builder->where('archived', 1);
    }
    
    public function scopePending($builder)
    {
        if (Request::segment(1) == 'admin') {
            return $builder;
        }

        if (config('settings.ads_review_activation')) {
            return $builder->where('active', 0)->orWhere('reviewed', 0);
        } else {
            return $builder->where('active', 0);
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
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
