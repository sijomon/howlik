<?php
/*

* 	CronController - Cron Jobs
*	@Developers Team 	: Shrishti Info Solutions
*	@author				: vineeth.kk@shrishtionline.com
*	@date 				: 08/04/2019

*/

?>
<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use App\Larapen\Models\User;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\Country as CountryModel;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;

use App\Larapen\Models\Category;
use Response;

class CronController extends FrontController
{
    public function getGoogleDetails(HttpRequest $request)
    {
		$gKey = get_google_key();
		
		$biz = Business::where('googleId', '!=', '')->whereDate('google_update', '=', '0000-00-00 00:00:00')->offset(0)->limit(20)->get();
		if(count($biz) > 0){
			foreach($biz as $key => $value){
				googlefetchdetails($value->id, 1);
			}
		}
	}
}