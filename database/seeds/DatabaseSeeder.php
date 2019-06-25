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
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // $this->call(UserTableSeeder::class);
        // Model::reguard();

        $this->call(SchemaSeeder::class);
        $this->call(AdTypeTableSeeder::class);
        $this->call(AdvertisingTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ContinentsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(PacksTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(ReportTypeTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(TimeZonesTableSeeder::class);
        $this->call(UserTypeTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CitiesSeeder::class);

        /*
         * Debug
         *
         * Run in consol (to show error):
         * composer dump-autoload
         * php artisan db:seed
         */
        $this->call('SettingsTableSeeder');
    }
}
