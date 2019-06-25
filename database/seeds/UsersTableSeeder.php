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

class UsersTableSeeder extends Seeder
{
    /**
     * Insert data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array(
            0 => array(
                'id'                 => '1',
                'country_code'       => 'FI',
                'user_type_id'       => '1',
                'gender_id'          => '1',
                'name'               => 'Administrator',
                'about'              => 'Administrator',
                'phone'              => '61228282',
                'phone_hidden'       => '0',
                'email'              => 'admin@yoursite.com',
                'password'           => '$2y$10$k5jUtH2EYKl9F.5rT5A4SeCU9k6GLjfxESPggYToigaZpbgHIYKpW',
                'remember_token'     => 'Br2KkFuD5ighe1JkSuZhWnGAfzbZeHUtRmfwafLSsw2L3HurBF0HbBX4M9fw',
                'is_admin'           => '1',
                'comments_enabled'   => '1',
                'receive_newsletter' => '1',
                'receive_advice'     => '1',
                'ip_addr'            => null,
                'provider'           => null,
                'provider_id'        => null,
                'activation_token'   => null,
                'active'             => '0',
                'blocked'            => '0',
                'closed'             => '0',
                'last_login_at'      => '2015-09-29 15:39:54',
                'created_at'         => '2015-09-28 13:42:23',
                'updated_at'         => '2015-09-29 15:40:25',
                'deleted_at'         => null,
            ),
            /*
            1 => array(
                'id'                 => '2',
                'country_code'       => 'PL',
                'user_type_id'       => '2',
                'gender_id'          => '1',
                'name'               => 'John',
                'about'              => 'User Demo',
                'phone'              => '94252504',
                'phone_hidden'       => '0',
                'email'              => 'user@demosite.com',
                'password'           => '$2y$10$wG3CkkrZr.PJpIU/XF7FgO2PnC/ODw4gXqR9u2nQ5txYNTfJeD7Pu',
                'remember_token'     => 'Qfk0XkZwNqzU0eXjCDy6QLEa6VzuowKP7iSTkc87yGMCm2nUtdON4FOzQRRp',
                'is_admin'           => '0',
                'comments_enabled'   => '1',
                'receive_newsletter' => '0',
                'receive_advice'     => '0',
                'ip_addr'            => null,
                'provider'           => null,
                'provider_id'        => null,
                'activation_token'   => null,
                'active'             => '1',
                'blocked'            => '0',
                'closed'             => '0',
                'last_login_at'      => '2015-11-24 09:37:55',
                'created_at'         => '2015-09-29 15:41:35',
                'updated_at'         => '2016-04-01 21:36:32',
                'deleted_at'         => null,
            ),
            */
        ));
    }
}
