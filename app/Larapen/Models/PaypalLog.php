<?php

	namespace App\Larapen\Models;

	use App\Larapen\Scopes\ActiveScope;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\File;

	class PaypalLog extends BaseModel
	{
		/**
		 * The table associated with the model.
		 *
		 * @var string
		 */
		protected $table = 'paypal_log';
		
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
		protected $fillable = ['pl_details', 'pl_status', 'pl_response'];
		
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
		
		public function seller()
		{
			$seller = '-NA-';
			$pl_detailsA = unserialize($this->pl_details);
			if($this->pl_type == 'gift_cert'){
				if(isset($pl_detailsA['biz']) && sizeof($pl_detailsA['biz'])>0){
					$seller = '<a href="'.url('profiles/'.$pl_detailsA['biz']['user_id']).'" target="_blank">'.$pl_detailsA['biz']['name'].'</a>';
				}
			}else{
				if(isset($pl_detailsA['event']) && sizeof($pl_detailsA['event'])>0){
					$seller = '<a href="'.url('profiles/'.$pl_detailsA['event']['user_id']).'" target="_blank">'.$pl_detailsA['event']['name'].'</a>';
				}
			}
			return $seller;
		}
		
		public function title()
		{
			$title = '-NA-';
			$pl_detailsA = unserialize($this->pl_details);
			if($this->pl_type == 'gift_cert'){
				if(isset($pl_detailsA['biz']) && sizeof($pl_detailsA['biz'])>0){
					$url = slugify($pl_detailsA['biz']['title']);
					$title = '<a href="'.url($url.'/'.$pl_detailsA['biz_id'].'.html').'" target="_blank">'.$pl_detailsA['biz']['title'].'</a>';
				}
			}else{
				if(isset($pl_detailsA['event']) && sizeof($pl_detailsA['event'])>0){
					$title = '<a href="'.url('preview/event/'.$pl_detailsA['eve_id']).'" target="_blank">'.$pl_detailsA['event']['event_name'].'</a>';
				}
			}
			return $title;
		}
		
		public function type()
		{
			if($this->pl_type == 'gift_cert'){
				return 'Gift Certificate';
			}else{
				return 'Event Ticket';
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
		
		public function trans_id()
		{
			$transId = '-NA-';
			if($this->pl_status==1){
				$pl_responseA = unserialize($this->pl_response);
				if(isset($pl_responseA['txn_id']) && $pl_responseA['txn_id']!=''){
					$transId = $pl_responseA['txn_id'].' ';
				}
			}
			return $transId;
		}
		
		public function track_id()
		{
			$trackId = '-NA-';
			if($this->pl_status==1){
				$pl_responseA = unserialize($this->pl_response);
				if(isset($pl_responseA['ipn_track_id']) && $pl_responseA['ipn_track_id']!=''){
					$trackId = $pl_responseA['ipn_track_id'].' ';
				}
			}
			return $trackId;
		}
		
		public function pay_status()
		{
			$payStatus = '<select id="pay_status'.$this->id.'" name="pay_status[]" onchange="updatePayStatus('.$this->id.');" onfocus="focusPayStatus('.$this->id.');">';
			$sel = '';
			if($this->pay_status == '0'){
				$sel = 'selected="selected"';
			}
			$payStatus .= '<option '.$sel.' value="0">Pending</option>';
			$sel = '';
			if($this->pay_status == '1'){
				$sel = 'selected="selected"';
			}
			$payStatus .= '<option '.$sel.' value="1">Paid</option>';
			$payStatus .= '</select>';
			return $payStatus;
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
