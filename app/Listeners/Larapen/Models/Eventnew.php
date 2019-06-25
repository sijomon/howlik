<?php
namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Eventnew extends BaseModel 
{
   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
   
    
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
        'event_type_id',
        'event_name',
		'event_topic',
        'event_date',
        'event_starttime',
		'eventEnd_date',
        'event_endtime',
        'event_place',
        'about_event',
        'event_image1',
		'event_image2',
		'event_image3',  
		'organization',
		'org_description',
		'privacy',	
		'link_to_social',
		'fb_link',
		'twitter',
		'insta',
		'social_share',
		'ticket_type',
		'ticket_details',
		'subadmin1_code',
		'event_place',
		'visible_to',
		'visible_code',
		'active'		
	];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        //static::addGlobalScope(new ActiveScope());
        
        // before delete() method call this
      //  static::deleting(function ($user) {});
    }
    
    public function getActiveHtml()
    {
        if ($this->active == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }
   /* public function Getcountry()
	{
		$id = $this->id;
		$c 	= \DB::table('countries')
					->select('countries.asciiname')
					->join('events','events.country_code','=','countries.code')
					->where('events.id',$id)
					->get();
		
		$b = [];
		foreach($c as &$ct){
			
				$b[] = $ct->asciiname;
				//$b = array_map('intval', $b); 
		}
		unset($c);
		return $b[0];
		
		//echo "<pre>";print_r($b[0]);die;
	}*/
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
  
    public function country()
    {
        return $this->belongsTo('App\Larapen\Models\Country', 'country_code');
    }
    
    
    public function eventType()
    {
        return $this->belongsTo('App\Larapen\Models\EventType', 'event_type_id');
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
        if (!isset($this->attributes['created_at']) and is_null($this->attributes['created_at'])) {
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
