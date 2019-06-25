<?php
namespace App\Larapen\Models;

use App\Larapen\Scopes\ActiveTranslationScope;
use Illuminate\Database\Eloquent\Model;

class Catcsv extends BaseModel
{
   
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catcsv';
    
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
        'category',
        'name',
        'address',
        'phone',
        'fax',
        'description',
        'city',
        'country'
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
