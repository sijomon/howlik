<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\File;

	class EventVisit extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'event_visits'; 
		
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
		protected $fillable = ['event_id', 'ip_address','country_code'];
		
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
		public function event()
		{
			return $this->belongsTo('App\Larapen\Models\Event', 'event_id');
		}
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
		
		/*
		|--------------------------------------------------------------------------
		| MUTATORS
		|--------------------------------------------------------------------------
		*/
	}
