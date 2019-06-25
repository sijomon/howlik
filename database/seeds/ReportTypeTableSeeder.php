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

class ReportTypeTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('report_type')->delete();
        
        \DB::table('report_type')->insert(array(
            0 => array(
                'id'               => '2',
                'translation_lang' => 'en',
                'translation_of'   => '2',
                'name'             => 'Fraud',
            ),
            1 => array(
                'id'               => '3',
                'translation_lang' => 'en',
                'translation_of'   => '3',
                'name'             => 'Duplicate',
            ),
            2 => array(
                'id'               => '4',
                'translation_lang' => 'en',
                'translation_of'   => '4',
                'name'             => 'Spam',
            ),
            3 => array(
                'id'               => '5',
                'translation_lang' => 'en',
                'translation_of'   => '5',
                'name'             => 'Wrong category',
            ),
            4 => array(
                'id'               => '6',
                'translation_lang' => 'en',
                'translation_of'   => '6',
                'name'             => 'Other',
            ),
        ));
    }
}
