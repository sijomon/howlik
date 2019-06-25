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

class AdTypeTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ad_type')->delete();
        
        \DB::table('ad_type')->insert(array(
            0 => array(
                'id'               => '1',
                'translation_lang' => 'en',
                'translation_of'   => '1',
                'name'             => 'Private',
                'active'           => '1',
            ),
            1 => array(
                'id'               => '2',
                'translation_lang' => 'en',
                'translation_of'   => '2',
                'name'             => 'Business',
                'active'           => '1',
            ),
            2 => array(
                'id'               => '3',
                'translation_lang' => 'fr',
                'translation_of'   => '1',
                'name'             => 'Particulier',
                'active'           => '1',
            ),
            3 => array(
                'id'               => '4',
                'translation_lang' => 'fr',
                'translation_of'   => '2',
                'name'             => 'Professionnel',
                'active'           => '1',
            ),
            4 => array(
                'id'               => '5',
                'translation_lang' => 'es',
                'translation_of'   => '1',
                'name'             => 'Private',
                'active'           => '1',
            ),
            5 => array(
                'id'               => '6',
                'translation_lang' => 'de',
                'translation_of'   => '1',
                'name'             => 'Private',
                'active'           => '1',
            ),
            6 => array(
                'id'               => '7',
                'translation_lang' => 'pt',
                'translation_of'   => '1',
                'name'             => 'Private',
                'active'           => '1',
            ),
            7 => array(
                'id'               => '8',
                'translation_lang' => 'es',
                'translation_of'   => '2',
                'name'             => 'Business',
                'active'           => '1',
            ),
            8 => array(
                'id'               => '9',
                'translation_lang' => 'de',
                'translation_of'   => '2',
                'name'             => 'Business',
                'active'           => '1',
            ),
            9 => array(
                'id'               => '10',
                'translation_lang' => 'pt',
                'translation_of'   => '2',
                'name'             => 'Business',
                'active'           => '1',
            ),
        ));
    }
}
