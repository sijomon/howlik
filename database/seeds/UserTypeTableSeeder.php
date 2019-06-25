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

class UserTypeTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_type')->delete();
        
        \DB::table('user_type')->insert(array(
            0 => array(
                'id'     => '1',
                'name'   => 'Admin',
                'active' => '0',
            ),
            1 => array(
                'id'     => '2',
                'name'   => 'Professional',
                'active' => '1',
            ),
            2 => array(
                'id'     => '3',
                'name'   => 'Individual',
                'active' => '1',
            ),
        ));
    }
}
