<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\File;

	class PaymentSettings extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'payment_settings';
		
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
		protected $fillable = ['title', 'mode', 'details'];
		
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
		
		public function amount()
		{
			$amount = '-NA-';
			$pl_detailsA = unserialize($this->pl_details);
			if($this->pl_type == 'gift_cert'){
				$amount = '';
				if(isset($pl_detailsA['curr_code']) && $pl_detailsA['curr_code']!=''){
					$amount = $pl_detailsA['curr_code'].' ';
				}
				if(isset($pl_detailsA['gift_amount']) && $pl_detailsA['gift_amount']!=''){
					$amount .= $pl_detailsA['gift_amount'];
				}
			}else{
				$amount = '';
				if(isset($pl_detailsA['curr_code']) && $pl_detailsA['curr_code']!=''){
					$amount = $pl_detailsA['curr_code'].' ';
				}
				if(isset($pl_detailsA['ticket_amount']) && $pl_detailsA['ticket_amount']!=''){
					$amount .= $pl_detailsA['ticket_amount'];
				}
			}
			return $amount;
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
