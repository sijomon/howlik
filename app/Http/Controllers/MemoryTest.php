<?php
/*

* 	PendingPaymentAPI	- Pending Payment API
*	@Developers Team 	: Shrishti Info Solutions
*	@author				: vineeth.kk@shrishtionline.com
*	@date 				: 08/12/2016

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

class MemoryTest extends FrontController
{
    protected $name = 'command:memoryleak';
    protected $description = 'Demonstrates memory leak.';

    public function fire()
    {
        //ini_set("memory_limit","12M");

        for ($i = 0; $i < 5; $i++)
        {
			echo "<br>";
			DB::connection()->disableQueryLog();
            var_dump(memory_get_usage());
            $this->external_function($i);
        }
    }

    function external_function($id)
    {
        // Next line causes memory leak - comment out to compare to normal behavior
        $users = User::where('id', '=', 2)->first();

        unset($users);
        // User goes out of scope at the end of this function
		
		DB::connection()->disableQueryLog();
    }
}