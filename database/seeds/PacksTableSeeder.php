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

class PacksTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('packs')->delete();
        
        \DB::table('packs')->insert(array(
            0  => array(
                'id'               => '1',
                'translation_lang' => 'en',
                'translation_of'   => '1',
                'name'             => 'Regular List',
                'description'      => 'Regular List',
                'price'            => '0',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => '0',
                'lft'              => '2',
                'rgt'              => '3',
                'depth'            => '1',
                'active'           => '0',
            ),
            1  => array(
                'id'               => '2',
                'translation_lang' => 'en',
                'translation_of'   => '2',
                'name'             => 'Urgent Ad',
                'description'      => 'Urgent',
                'price'            => '4',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => '0',
                'lft'              => '6',
                'rgt'              => '7',
                'depth'            => '1',
                'active'           => '0',
            ),
            2  => array(
                'id'               => '3',
                'translation_lang' => 'en',
                'translation_of'   => '3',
                'name'             => 'Top page Ad',
                'description'      => 'Top Ads',
                'price'            => '7',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => '0',
                'lft'              => '4',
                'rgt'              => '5',
                'depth'            => '1',
                'active'           => '0',
            ),
            3  => array(
                'id'               => '4',
                'translation_lang' => 'en',
                'translation_of'   => '4',
                'name'             => 'Top page Ad + Urgent Ad',
                'description'      => 'Featured Ads',
                'price'            => '9',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => '0',
                'lft'              => '8',
                'rgt'              => '9',
                'depth'            => '1',
                'active'           => '0',
            ),
            4  => array(
                'id'               => '8',
                'translation_lang' => 'fr',
                'translation_of'   => '1',
                'name'             => 'Gratuit',
                'description'      => 'Annonce gratuite',
                'price'            => '0',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '2',
                'rgt'              => '3',
                'depth'            => '1',
                'active'           => '1',
            ),
            5  => array(
                'id'               => '9',
                'translation_lang' => 'es',
                'translation_of'   => '1',
                'name'             => 'Regular List',
                'description'      => 'Regular List',
                'price'            => '0',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '2',
                'rgt'              => '3',
                'depth'            => '1',
                'active'           => '1',
            ),
            6  => array(
                'id'               => '10',
                'translation_lang' => 'fr',
                'translation_of'   => '2',
                'name'             => 'Annonce urgente',
                'description'      => 'Urgent',
                'price'            => '4',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '6',
                'rgt'              => '7',
                'depth'            => '1',
                'active'           => '1',
            ),
            7  => array(
                'id'               => '11',
                'translation_lang' => 'es',
                'translation_of'   => '2',
                'name'             => 'Urgent Ad',
                'description'      => 'Urgent',
                'price'            => '4',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '6',
                'rgt'              => '7',
                'depth'            => '1',
                'active'           => '1',
            ),
            8  => array(
                'id'               => '12',
                'translation_lang' => 'fr',
                'translation_of'   => '3',
                'name'             => 'Top annonce',
                'description'      => 'Annonce listée en haut de la page des résultats de recherche',
                'price'            => '7',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '4',
                'rgt'              => '5',
                'depth'            => '1',
                'active'           => '1',
            ),
            9  => array(
                'id'               => '13',
                'translation_lang' => 'es',
                'translation_of'   => '3',
                'name'             => 'Top page Ad',
                'description'      => 'Top Ads',
                'price'            => '7',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '4',
                'rgt'              => '5',
                'depth'            => '1',
                'active'           => '1',
            ),
            10 => array(
                'id'               => '14',
                'translation_lang' => 'fr',
                'translation_of'   => '4',
                'name'             => 'Urgente + Top annonce',
                'description'      => 'Urgente + Top annonce',
                'price'            => '9',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '8',
                'rgt'              => '9',
                'depth'            => '1',
                'active'           => '1',
            ),
            11 => array(
                'id'               => '15',
                'translation_lang' => 'es',
                'translation_of'   => '4',
                'name'             => 'Top page Ad + Urgent Ad',
                'description'      => 'Featured Ads',
                'price'            => '9',
                'currency_code'    => 'USD',
                'duration'         => '30',
                'parent_id'        => null,
                'lft'              => '8',
                'rgt'              => '9',
                'depth'            => '1',
                'active'           => '1',
            ),
        ));
    }
}
