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
	use Illuminate\Database\Eloquent\Model;

	class GiftRecipient extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'gift_recipients';
		
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
		protected $fillable = ['biz_id','gift_id','gift_code','recipient_name','recipient_email','recipient_message','sender_name','sender_id','active'];
		
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
		protected $dates = ['created_at','updated_at'];
		
		/*
		|--------------------------------------------------------------------------
		| FUNCTIONS
		|--------------------------------------------------------------------------
		*/
		protected static function boot()
		{
			parent::boot();
			
			static::addGlobalScope(new ActiveScope());
		}
		
		/*
		|--------------------------------------------------------------------------
		| RELATIONS
		|--------------------------------------------------------------------------
		*/
		public function business()
		{
			return $this->belongsTo('App\Larapen\Models\Business', 'biz_id');
		}
		public function certificate()
		{
			return $this->belongsTo('App\Larapen\Models\GiftCertificate', 'gift_id');
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
