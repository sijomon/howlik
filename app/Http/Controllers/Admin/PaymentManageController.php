<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Models\PaypalLog;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\PaymentManageController as StoreRequest;
use App\Http\Requests\Admin\PaymentManageController as UpdateRequest;
use Request;
use Carbon\Carbon;

class PaymentManageController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\PaypalLog",
		"where" => array(0=>array('field'=>'pl_status', 'cond'=>'=', 'value'=>'1')),
		"orderby" => array('field'=>'created_at', 'type'=>'DESC'),
		"sort" => array('col'=>'6', 'type'=>'desc'),
        "entity_name" => "payment management report",
        "entity_name_plural" => "payment management reports",
        "route" => "admin/payment-report",
        "reorder" => false,
		"filter" => true,
		"edit_permission" => false,
		"delete_permission" => false,
		"add_permission" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'seller',
                'label' => "Seller",
                'type' => "model_function",
                'function_name' => 'seller',
            ],
			[
                'name' => 'title',
                'label' => "Business / Event",
                'type' => "model_function",
                'function_name' => 'title', 
            ],
			[
                'name' => 'type',
                'label' => "Type",
                'type' => "model_function",
                'function_name' => 'type',
            ],
			[
                'name' => 'amount',
                'label' => "Amount",
                'type' => "model_function",
                'function_name' => 'amount',
            ],
			[
                'name' => 'trans_id',
                'label' => "Trans Id",
                'type' => "model_function",
                'function_name' => 'trans_id',
            ],
			[
                'name' => 'track_id',
                'label' => "Track Id",
                'type' => "model_function",
                'function_name' => 'track_id',
            ],
			[
                'name' => 'created_at',
                'label' => "Paid at",
            ],
			[
                'name' => 'pay_status',
                'label' => "Pay Status",
                'type' => "model_function",
                'function_name' => 'pay_status',
            ],
        ],
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'pay_report',
                'label' => "Payment Report",
                'type' => 'pay_report',
            ],
        ],
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
	
	public function payreport()
	{
		$etype  	= Request::get('etype');
		$from 		= Request::get('frm');
		$to 		= Request::get('to');
		$today 		= Carbon::createFromFormat('Y-m-d H', $from.' 0')->toDateTimeString();
		$tomorrow 	= Carbon::createFromFormat('Y-m-d H', $to.' 24')->toDateTimeString();
		$payHis 	= PaypalLog::where('pl_status', 1)->orderBy('created_at', 'DESC')->whereBetween('created_at', array($today, $tomorrow));
		if($etype=='event'){
			$payHis->where('pl_type', 'event_tkt');
		}elseif($etype=='gift'){
			$payHis->where('pl_type', 'gift_cert');
		}
		
		$crdTbl = '<table id="crudTable" class="table table-bordered table-striped display dataTable" role="grid" aria-describedby="crudTable_info">
                    <thead>
                      <tr role="row">
						<th>Seller</th>
						<th>Business / Event</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Trans Id</th>
						<th>Track Id</th>
						<th>Paid at</th>
						<th>Pay Status</th>
					  </tr>
                    </thead>
                    <tbody>';
		$payHisA = $payHis->get();
		foreach($payHisA as $key => $value){
			$crdTbl .= '<tr data-entry-id="'.$value['id'].'">';
			$crdTbl .= '<td>'.$value->seller().'</td>';
			$crdTbl .= '<td>'.$value->title().'</td>';
			$crdTbl .= '<td>'.$value->type().'</td>';
			$crdTbl .= '<td>'.$value->amount().'</td>';
			$crdTbl .= '<td>'.$value->trans_id().'</td>';
			$crdTbl .= '<td>'.$value->track_id().'</td>';
			$crdTbl .= '<td>'.$value['created_at'].'</td>';
			$crdTbl .= '<td>'.$value->pay_status().'</td>';
			$crdTbl .= '</tr>';
		}
		$crdTbl .= '</tbody></table>';
		
		echo $crdTbl;
	}
	
	public function payreportstatus(){
		$id = Request::get('id');
		$p_status = Request::get('p_status');
		$payLog   = PaypalLog::where('id', $id)->first();
		$payLog->pay_status = $p_status;
		$payLog->save();
	}
}