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
	use Illuminate\Support\Facades\File;

	class UserInterest extends BaseModel
	{
		
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'user_interest';
		
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
		//public $timestamps = false;
		
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
		protected $fillable = ['int_title', 'int_img', 'active', 'translation_lang', 'translation_of'];
		
		protected $translatable = ['int_title'];
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
