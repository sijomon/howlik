<?php

namespace App\Larapen\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

use App\Larapen\Models\Category;
use Larapen\CountryLocalization\Models\Location;
use PulkitJalan\GeoIP\Facades\GeoIP;
use Larapen\CountryLocalization\Facades\CountryLocalization;

use Request;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        //
        
        parent::boot($router);
		
		//view()->composer('classified.layouts.layout', function($view)
		view()->composer('*', function($view)
		{
			$lang = App::getLocale();
			$category = Category::where('parent_id', '0')->where('translation_lang',$lang)->get();
			$view->with('vcategory', $category);
			
			$view->with('vlang', $lang);
			$view->with('vlocations', array());
			
			Request::session()->put('vin_lang_code',  $lang);
			
			$country = CountryLocalization::findCountry();
			if($country->has('code')){
				$vlocations = Location::where('code', 'LIKE', $country->get('code').'.%')->orderBy('asciiname', 'ASC')->get()->keyBy('id');
				$tvar = GeoIP::get();
				$defRegion='';
				$vlocationsA = array();
				if(isset($tvar['region']) && trim($tvar['region'])!=''){
					foreach($vlocations as $key => $v_loc){
						if($lang!='ar') $v_loc->name =  $v_loc->asciiname;
						if($defRegion=='')$defRegion = $v_loc->name;
						if(strtolower(trim($v_loc->asciiname))==strtolower(trim($tvar['region']))){
							$defRegion = $v_loc->name;
						}
						$vlocationsA[$key]['id'] = $v_loc->id;
						$vlocationsA[$key]['name'] = $v_loc->name;
						$vlocationsA[$key]['asciiname'] = $v_loc->asciiname;
					}
				}
				$view->with('vregion', $defRegion);
				$view->with('vlocations', $vlocationsA);
			}
			
		});
    }
    
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
