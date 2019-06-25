<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Auth\Authenticatable;
	use Illuminate\Database\Eloquent\Model;

	use Illuminate\Foundation\Auth\Access\Authorizable;

	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Hash;

	class EventType extends BaseModel 
	{
	   
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'event_type';
		
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
			'name',
			'active',
			'translation_lang', 
			'translation_of'
		];
		
		protected $translatable = ['name'];
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
			
			// before delete() method call this
			// static::deleting(function ($user) {});
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
		public function events()
		{
			return $this->hasMany('App\Larapen\Models\Event');
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
