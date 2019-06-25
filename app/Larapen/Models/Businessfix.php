<?php

namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class Businessfix extends BaseModel
{
    //use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businessfix';
    
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
        'keywords',
        'title',
        'description',
        'title_ar',
        'description_ar',
        'biz_hours',
        'phone',
        'biz_email',
        'web',
        'address1',
        'address2',
        'zip',
        'subadmin1_code',
		'city_id',
        'lat',
        'lon',
		'more_info',
        'ip_addr',
        'visits',
        'booking',
        'activation_token',
        'active'
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
        static::deleting(function ($busines) {
            // Delete all messages
            //$busines->messages()->delete();
            
            
            // Remove associated files
            if (is_numeric($busines->id)) {
                // Delete all pictures files
                if (!is_null($busines->businessimages)) {
                    $picture_path = public_path() . '/uploads/pictures/';
                    if (File::exists($picture_path . strtolower($busines->country_code) . '/' . $busines->id)) {
                        File::deleteDirectory($picture_path . strtolower($busines->country_code) . '/' . $busines->id);
                    }
                }
            }
            
            // Delete all pictures entries in database
            $busines->businessimages()->delete();
            
        });


        // UPDATING - before update() method call this
        static::updating(function ($busines) {
            // Get category
            $cat = Category::find(Input::get('parent'));
            if (!is_null($cat)) {
                // Pictures files cleanup by category type
                if (in_array($cat->type, ['job-offer', 'job-search'])) {
                    $pictures = Picture::where('biz_id', $busines->id)->get();
                    if (!is_null($pictures)) {
                        foreach ($pictures as $picture) {
                            $picture->delete();
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
    
    public function getOfferHtml()
    {
        //return '<a data-toggle="modal" data-target="#myModal" href="/' . config('app.locale') . '/' . slugify($this->title_ar) . '/' . $this->id .'" target="_blank">' . $this->title_ar . '</a>';
        return '<p onclick="getPopup(\''.$this->id.'\')">' . $this->id . '</p>';
    }
	
    public function getExtraHtml()
    {
		//<p><span onclick="getPopup(\''.$this->id.'\')" class="btn btn-xs btn-default"> Offers </span>
		return '<p><span onclick="getReviewPopup(\''.$this->id.'\')" class="btn btn-xs btn-default"> Reviews </span><span onclick="getGiftPopup(\''.$this->id.'\')" class="btn btn-xs btn-default"> Certificates </span></p>';	
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
    
    public function getUserHtml()
    {
        if (isset($this->user) and !is_null($this->user)) {
            $lang = config('app.locale');
            $user_name = $this->user->name;
            $user_slug = slugify($user_name);
            $user_id = $this->user->id;
            
            return '<p>' . $user_name . '</p>';
        } else {
            return $this->user_id;
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

	/*public function getRatingsHtml()
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
		
	}*/
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    public function category()
    {
        return $this->belongsTo('App\Larapen\Models\Category', 'category_id');
    }
    
    public function city()
    {
        return $this->belongsTo('App\Larapen\Models\City', 'city_id');
    }
    
	public function location()
    {
        return $this->belongsTo('App\Larapen\Models\SubAdmin1', 'subadmin1_code');
    }
	
    public function country()
    {
        return $this->belongsTo('App\Larapen\Models\Country', 'country_code');
    }
    
    /*public function messages()
    {
        return $this->hasMany('App\Larapen\Models\Message', 'ad_id');
    }*/
    
    public function businessimages()
    {
        return $this->hasMany('App\Larapen\Models\BusinessImage', 'biz_id');
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
		
    	return $builder->where('active', 1);
       /* if (config('settings.ads_review_activation')) {
            return $builder->where('active', 1)->where('reviewed', 1)->where('archived', 0);
        } else {
            return $builder->where('active', 1)->where('archived', 0);
        }*/
    }
	
	public function scopePending($builder)
    {
        if (Request::segment(1) == 'admin') {
            return $builder;
        }
		
		return $builder->where('active', 0);
        /*if (config('settings.ads_review_activation')) {
            return $builder->where('active', 0)->orWhere('reviewed', 0);
        } else {
            return $builder->where('active', 0);
        }*/
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
