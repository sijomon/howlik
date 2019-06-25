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

	namespace App\Http\Controllers;

	use Illuminate\Support\Facades\View;
	use Larapen\CountryLocalization\Facades\CountryLocalization;
	use Larapen\CountryLocalization\Helpers\Country;
	use Torann\LaravelMetaTags\Facades\MetaTag;
	use Illuminate\Http\Request as HttpRequest;

	class PaypalController extends FrontController
	{
		public function index()
		{
			$data = array();
			
			return view('classified.paypal.index', $data);
		}
		
		public function process()
		{
			$data = array();
			
			return view('classified.paypal.process', $data);
		}
	}
