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

class SchemaSeeder extends Seeder
{
    /**
     * Create database tables - If not exists
     *
     * @return void
     */
    public function run()
    {
        $tables = \DB::select('SHOW TABLES');

		// Create tables if not exists
        if (empty($tables)) {
            $schemaDbSqlFile = database_path('sql/schema.sql');
            if (file_exists($schemaDbSqlFile)) {
                \DB::unprepared(file_get_contents($schemaDbSqlFile));
            }
        }
    }
}
