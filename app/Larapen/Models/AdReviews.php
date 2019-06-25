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

class AdReviews extends BaseModel
{
    //use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
     protected $primaryKey = 'id';
    //protected $appends = ['created_at_ta'];
    
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
        'user_id',
        'ads_id',
        'review',
        'created_at',
        'updated_at'
        
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
    protected $dates = ['created_at', 'updated_at'];

    public function __construct()
    {
       // echo request()->id;
        parent::__construct();
    }
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {		
        parent::boot();
		//echo "hello";die;
         //static::addGlobalScope(new ActiveTranslationScope());
       
    }
	
   
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function ads()
	{
		return $this->belongsTo('App\Larapen\Models\Ad','asd_id');
	}
	/*  public function user()
    {
		return $this->belongsToMany('App\Larapen\Models\User','review','user_id');
    }
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
    
    public function reviews()
    {
        return $this->belongsTo('App\Larapen\Models\AdReviews', 'review');
    }
    
    /*
    public function payment()
    {
        // @todo: Delete this method. Check if it's unused before.
        //return $this->belongsToMany('App\Larapen\Models\PaymentMethod', 'payments', 'ad_id', 'payment_method_id');
    }
    
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
    
    public function user()
    {
        return $this->belongsTo('App\Larapen\Models\User', 'user_id');
    }*/
    
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
	public function getuser()
	{
		//return $this->id;
		$slq = \DB::table('review')
						->join('users','review.user_id','=','users.id') 
						->select('name')
						
						->where('review.id',$this->id)->first();
		return $slq->name; 
		
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
