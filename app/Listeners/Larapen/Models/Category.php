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

use App\Larapen\Scopes\ActiveTranslationScope;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Category extends BaseModel implements SluggableInterface
{
    use SluggableTrait;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    protected $appends = ['tid'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    
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
        'parent_id',
        'name',
        'slug',
        'description',
        'picture',
        'css_class',
        'active',
        'lft',
        'rgt',
        'depth',
        'translation_lang',
        'translation_of',
        'type'
    ];
    protected $translatable = ['name', 'slug', 'description'];
    protected $sluggable = [
        'build_from' => 'slug_or_name',
        'save_to' => 'slug',
        'on_update' => true,
        'unique' => true
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
        
        static::addGlobalScope(new ActiveTranslationScope());
        
        // before delete() method call this
        static::deleting(function ($ad) {
            // Delete all children categories
            $ad->children()->delete();
            
            // Delete all translated categories
            $ad->translated()->delete();
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
    
    public static function transById($id, $locale = '')
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
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
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
    public function getSlugOrNameAttribute()
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
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
