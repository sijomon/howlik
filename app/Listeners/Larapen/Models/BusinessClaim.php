<?php
namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveTranslationScope;
use Illuminate\Database\Eloquent\Model;

class BusinessClaim extends BaseModel
{
   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businessClaimRequests';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'biz_id',
        'user_id',
        'phone',
        'address1',
        'address2',
        'zip',
        'subadmin1_code',
		'city_id',
		'lat',
		'lon',
		'status',
		'status_msg'
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
    // protected $dates = [];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        //static::addGlobalScope(new ActiveTranslationScope());
        
    }
    
    /*public function getActiveHtml()
    {
        if ($this->active == 1) {
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }*/
    
    
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function business() 
    {
        return $this->belongsTo('App\Larapen\Models\Business', 'biz_id');
    }
	public function user()
    {
        return $this->belongsTo('App\Larapen\Models\User', 'user_id');
    }
	public function image()
    {
        return $this->hasOne('App\Larapen\Models\BusinessImage', 'biz_id', 'biz_id');
    }
	public function city()
    {
        return $this->belongsTo('App\Larapen\Models\City', 'city_id');
    }
    
	public function location()
    {
        return $this->belongsTo('App\Larapen\Models\SubAdmin1', 'subadmin1_code', 'code');
    }
	public function category()
    {
        return $this->belongsTo('App\Larapen\Models\Category', 'category_id');
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
    // The slug is created automatically from the "title" field if no slug exists.
   
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
