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

class AdvertisingTableSeeder extends Seeder
{
    /**
     * Import data
     *
     * @return void
     */
    public function run()
    {
        \DB::table('advertising')->delete();

        \DB::table('advertising')->insert(array(
            0 => array(
                'id' => '1',
                'slug' => 'top',
                'provider_name' => 'Google AdSense',
                'tracking_code_large' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- large970x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:970px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="8943644949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'tracking_code_medium' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- medium728x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:728px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="5818394949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'tracking_code_small' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- mobile320x100-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:320px;height:100px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="2864928545"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'active' => '0',
            ),
            1 => array(
                'id' => '2',
                'slug' => 'bottom',
                'provider_name' => 'Google AdSense',
                'tracking_code_large' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- large970x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:970px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="8943644949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'tracking_code_medium' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- medium728x90-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:728px;height:90px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="5818394949"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'tracking_code_small' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- mobile320x100-visualText -->\r\n<ins class="adsbygoogle"\r\n	 style="display:inline-block;width:320px;height:100px"\r\n	 data-ad-client="ca-pub-2461204719026790"\r\n	 data-ad-slot="2864928545"></ins>\r\n<script>\r\n	(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>',
                'active' => '0',
            ),
        ));
    }
}
