<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array(
            0 => array(
                'id'           => '1',
                'country_code' => null,
                'name'         => 'Paypal',
                'description'  => 'Paypal Express',
                'lft'          => null,
                'rgt'          => null,
                'depth'        => null,
                'active'       => '1',
            ),
        ));
    }
}
