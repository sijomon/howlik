<?php
/**
 * LaraClassified - Geo Classified Ads Software
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

class CitiesSeeder extends Seeder
{
    /**
     * Import data
     *
     * @return void
     */
    public function run()
    {
        // Import default cities
        $tableDataSqlFile = database_path('sql/data/required/ca-cities.sql');
        if (file_exists($tableDataSqlFile)) {
            \DB::unprepared(file_get_contents($tableDataSqlFile));
        }
    }
}
