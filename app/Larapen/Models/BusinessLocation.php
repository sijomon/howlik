<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\File;

	class BusinessLocation extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'businessLocations';
		
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
			'biz_id',
			'address_1',
			'address_2',
			'phone',
			'country_id',
			'location_id',
			'city_id',
			'zip_code',
			'lat',
			'lon',
			'active',
			'base',
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
