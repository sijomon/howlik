<?php

namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Cms extends BaseModel 
{
   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms';
    
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
       
        'cms_name',
		'cms_name_ar',
        'cms_description',
		'cms_description_ar',
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
        
        static::addGlobalScope(new ActiveScope());
        
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
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
  
    public function country()
    {
        return $this->belongsTo('App\Larapen\Models\Country', 'country_code');
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
