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

class ContinentsTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('continents')->delete();
        
        \DB::table('continents')->insert(array(
            0 => array(
                'id'     => '1',
                'code'   => 'AF',
                'name'   => 'Africa',
                'active' => '1',
            ),
            1 => array(
                'id'     => '2',
                'code'   => 'AN',
                'name'   => 'Antarctica',
                'active' => '1',
            ),
            2 => array(
                'id'     => '3',
                'code'   => 'AS',
                'name'   => 'Asia',
                'active' => '1',
            ),
            3 => array(
                'id'     => '4',
                'code'   => 'EU',
                'name'   => 'Europe',
                'active' => '1',
            ),
            4 => array(
                'id'     => '5',
                'code'   => 'NA',
                'name'   => 'North America',
                'active' => '1',
            ),
            5 => array(
                'id'     => '6',
                'code'   => 'OC',
                'name'   => 'Oceania',
                'active' => '1',
            ),
            6 => array(
                'id'     => '7',
                'code'   => 'SA',
                'name'   => 'South America',
                'active' => '1',
            ),
        ));
    }
}
