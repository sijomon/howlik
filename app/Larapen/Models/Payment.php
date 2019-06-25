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

use Illuminate\Database\Eloquent\Model;

class Payment extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    // public $timestamps = false;
    
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
    protected $fillable = ['ad_id', 'pack_id', 'payment_method_id'];
    
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
    public function getAdTitleHtml()
    {
        if ($this->ad) {
            return '<a href="/' . config('app.locale') . '/' . slugify($this->ad->title) . '/' . $this->ad_id . '.html" target="_blank">' . $this->ad->title . '</a>';
        } else {
            return $this->ad_id;
        }
    }
    
    public function getPackNameHtml()
    {
        if ($this->ad) {
            return $this->pack->name . ' (' . $this->pack->price . ' ' . $this->pack->currency_code . ')';
        } else {
            return $this->pack_id;
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function ad()
    {
        return $this->belongsTo('App\Larapen\Models\Ad', 'ad_id');
    }
    
    public function pack()
    {
        return $this->belongsTo('App\Larapen\Models\Pack', 'pack_id');
    }
    
    public function paymentMethod()
    {
        return $this->belongsTo('App\Larapen\Models\PaymentMethod', 'payment_method_id');
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
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
