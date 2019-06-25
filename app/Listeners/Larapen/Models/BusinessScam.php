<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\File;

	class BusinessScam extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'businessScam';
		
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
			'reason',
			'user_id',
			'ip_addr',
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
			
			//static::addGlobalScope(new ActiveScope());
		}
		
		public function getBizTitleHtml()
		{
			if ($this->business) {
				return '<a href="/' . config('app.locale') . '/' . slugify($this->business->title) . '/' . $this->business->id . '.html" target="_blank">' . $this->business->title . '</a>';
			} else {
				return 'Business not exists';
			}
		}
		
		public function getUser()
		{
			$name = '-Guest-';
			if(isset($this->user->name) && $this->user->name!=''){
				$name = $this->user->name;
			}
			return  $name;
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
		
		public function user()
		{
			return $this->belongsTo('App\Larapen\Models\User', 'user_id');
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
