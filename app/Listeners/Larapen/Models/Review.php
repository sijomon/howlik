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

class Review extends BaseModel
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
    protected $appends = ['created_at'];
    
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
        'biz_id',
        'user_id',
		'user_name',
        'review',
        'rating',
        'expense',
		'gtime'
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

    public function __construct(array $attributes = [])
    {
        // Added in release 1.1
      

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
        
      //  static::addGlobalScope(new ActiveTranslationScope());
        
        // before delete() method call this
       /* static::deleting(function ($ad) {
            // Delete all children categories
            $ad->children()->delete();
            
            // Delete all translated categories
            $ad->translated()->delete();
        });*/
		
    }
    
    public function getActiveHtml()
    {
		
        if ($this->active == 1) {
			
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        } else {
			
            return '<i class="fa fa-square-o" aria-hidden="true"></i>';
        }
    }
    
  /*  public static function transById($id, $locale = '')
    {
		
        if (empty($locale)) {
            $locale = config('app.locale');
        }
        
        $cat = static::where(function ($query) use ($id) {
            $query->where('translation_of', $id)->orWhere(function ($query) {
                $query->whereNull('translation_of');
            });
        })->where('translation_lang', $locale)->first();
        if (is_null($cat)) {
            $cat = static::find($id);
        }
        
        return $cat;
    }
    
    
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    
    public function ads()
    {
        return $this->hasManyThrough('App\Larapen\Models\Ad', 'App\Larapen\Models\Category', 'parent_id', 'category_id');
    }
    
    public function children()
    {
        return $this->hasMany('App\Larapen\Models\Category', 'parent_id');
    }
    
    public function translated()
    {
        return $this->hasMany('App\Larapen\Models\Category', 'translation_of');
    }
    
    public function lang()
    {
        return $this->hasOne('App\Larapen\Models\Category', 'translation_of', 'abbr');
    }
    
    public function parent()
    {
		
        return $this->belongsTo('App\Larapen\Models\Category', 'parent_id');
    }*/
    
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
  /*public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        
        return $this->name;
    }
    
    public function getTidAttribute()
    {
        if (!is_null($this->attributes['translation_of']) and $this->attributes['translation_of'] != '' and $this->attributes['translation_of'] != 0) {
            return $this->attributes['translation_of'];
        } else {
            return $this->attributes['id'];
        }
    }
    
    public function getTranslationOfAttribute()
    {
        if (!is_null($this->attributes['translation_of']) and $this->attributes['translation_of'] != '' and $this->attributes['translation_of'] != 0) {
            return $this->attributes['translation_of'];
        } else {
            return $this->attributes['id'];
        }
    }*/
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
