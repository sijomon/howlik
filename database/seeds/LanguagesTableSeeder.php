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

class LanguagesTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array(
            0 => array(
                'id'         => '1',
                'abbr'       => 'en',
                'locale'     => 'en_US',
                'name'       => 'English',
                'native'     => 'English',
                'flag'       => '',
                'app_name'   => 'english',
                'script'     => 'Latn',
                'active'     => '1',
                'default'    => '1',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ),
            1 => array(
                'id'         => '3',
                'abbr'       => 'fr',
                'locale'     => 'fr_FR',
                'name'       => 'French',
                'native'     => 'Français',
                'flag'       => '',
                'app_name'   => 'french',
                'script'     => 'Latn',
                'active'     => '1',
                'default'    => '0',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ),
            2 => array(
                'id'         => '5',
                'abbr'       => 'es',
                'locale'     => 'es_ES',
                'name'       => 'Spanish',
                'native'     => 'Español',
                'flag'       => '',
                'app_name'   => 'spanish',
                'script'     => 'Latn',
                'active'     => '1',
                'default'    => '0',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ),
            3 => array(
                'id'         => '6',
                'abbr'       => 'de',
                'locale'     => 'de_DE',
                'name'       => 'German',
                'native'     => 'Deutsch',
                'flag'       => '',
                'app_name'   => 'german',
                'script'     => 'Latn',
                'active'     => '0',
                'default'    => '0',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ),
            4 => array(
                'id'         => '7',
                'abbr'       => 'pt',
                'locale'     => 'pt_PT',
                'name'       => 'Portuguese',
                'native'     => 'Portuguese',
                'flag'       => '',
                'app_name'   => 'portuguese',
                'script'     => 'Latn',
                'active'     => '0',
                'default'    => '0',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ),
        ));
    }
}
