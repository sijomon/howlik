<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Input;

// ADMIN
Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
	
    //CRUD::resource('ad', 'AdController');
	CRUD::resource('business', 'BusinessController');
	Route::get('business_ajax', 'BusinessController@get_business_ajax');
	
	CRUD::resource('businessfix', 'BusinessfixController'); 
	Route::get('business_ajaxfix', 'BusinessfixController@get_business_ajax');
	
    CRUD::resource('category', 'CategoryController');
   // CRUD::resource('subcategory', 'SubCategoryController');
    //CRUD::resource('picture', 'PictureController');
	CRUD::resource('business-image', 'BusinessImageController');
	CRUD::resource('business-image-request', 'BusinessImageRequestController');
	CRUD::resource('business-claim-request', 'BusinessClaimRequestController');
	CRUD::resource('payment-report', 'PaymentManageController');
	CRUD::resource('business-info', 'BusinessInfoController');
    CRUD::resource('biz_type', 'AdTypeController');
	CRUD::resource('offers', 'offerController');
	CRUD::resource('reviews', 'AdReviewController');
    CRUD::resource('user', 'UserController');
    CRUD::resource('user-interest', 'UserInterestController');
    CRUD::resource('gender', 'GenderController');
    CRUD::resource('advertising', 'AdvertisingController');
    CRUD::resource('pack', 'PackController');
    CRUD::resource('payment', 'PaymentController');
	CRUD::resource('payment-settings', 'PaymentSettingsController');
    CRUD::resource('report_type', 'ReportTypeController');
    CRUD::resource('blacklist', 'BlacklistController');
    CRUD::resource('country', 'CountryController'); 
	CRUD::resource('city', 'CityController'); 
	CRUD::resource('business-scam', 'BusinessReportController');
	Route::get('city_ajax', 'CityController@get_city_ajax');
	Route::post('subadmin',['as'=>'subadmin','uses'=>'CityController@country_code']);
	Route::post('location',['as'=>'location','uses'=>'CityController@locationpost']);
	Route::post('keywordss',['as'=>'keywordss','uses'=>'BusinessController@keywords']);
	Route::post('getlocation',['as'=>'getlocation','uses'=>'BusinessController@location']);
	Route::post('getcity',['as'=>'getcity','uses'=>'BusinessController@city']);
	Route::post('imgaction',['as'=>'imgaction','uses'=>'BusinessImageRequestController@imgaction']);
	Route::post('claimaction',['as'=>'claimaction','uses'=>'BusinessClaimRequestController@claimaction']);
	Route::post('postbizoffers',['as'=>'postbizoffers','uses'=>'BusinessController@postOfferAdmin']);
	Route::post('editbizoffers',['as'=>'editbizoffers','uses'=>'BusinessController@editOfferAdmin']);
	Route::post('dropbizoffers',['as'=>'dropbizoffers','uses'=>'BusinessController@dropOfferAdmin']);
	Route::post('payreport',['as'=>'payreport','uses'=>'PaymentManageController@payreport']);
	Route::post('payreportstatus',['as'=>'payreportstatus','uses'=>'PaymentManageController@payreportstatus']);
	Route::post('postbizpics',['as'=>'postbizpics','uses'=>'BusinessController@upload_business_pics']);
	Route::post('dropbizpics',['as'=>'dropbizpics','uses'=>'BusinessController@delete_business_pics']);
	Route::post('postbizlocations',['as'=>'postbizlocations','uses'=>'BusinessController@postLocationAdmin']);
	Route::post('editbizlocations',['as'=>'editbizlocations','uses'=>'BusinessController@editLocationAdmin']);
	Route::post('dropbizlocations',['as'=>'dropbizlocations','uses'=>'BusinessController@dropLocationAdmin']);
    CRUD::resource('currency', 'CurrencyController');
    CRUD::resource('time_zone', 'TimeZoneController');
    CRUD::resource('event', 'EventController');
	CRUD::resource('event_type', 'EventTypeController');
	CRUD::resource('event_topic', 'EventTopicController');
    CRUD::resource('deal', 'DealController');
    CRUD::resource('cms', 'CmsController');
    Route::get('account', 'UserController@account');
	Route::get('reviews_det/{tid}', 'AdReviewController@detail');
	Route::get('review_delete/{rid}','AdReviewController@reviewdelete');
	Route::get('subcategory',['as'=>'subcategory','uses'=>'SubCategoryController@viewlist']);
	Route::get('subcategoryadd','SubCategoryController@add1');
	Route::get('getofferslist',['as'=>'getofferslist','uses'=>'BusinessController@getOffersList']);
	Route::get('getgiftslist',['as'=>'getgiftslist','uses'=>'BusinessController@getGiftsList']);
	Route::get('getreviewslist',['as'=>'getreviewslist','uses'=>'BusinessController@getReviewsList']);
	Route::post('subcat',['as'=>'subcat','uses'=>'SubCategoryController@subcategorypost']);
	Route::post('subcategorypostaddajax', [ 'as' => 'subcategorypostaddajax', 'uses' => 'SubCategoryController@subcategoryaddajax']);
	Route::get('subcategoryEdit/{id}', ['as' => 'subcategoryEdit', 'uses' => 'SubCategoryController@subcategoryEdit']);
	Route::get('subcategoryEdit1/{lang}/{id}', ['as' => 'subcategoryEdit1', 'uses' => 'SubCategoryController@subcategoryEditlang']);
	
	Route::post('subcategorytanslate', [ 'as' => 'subcategorytanslate', 'uses' => 'SubCategoryController@subcategoryaddajax1lang']);
	Route::post('subcategorypostaddajax1', [ 'as' => 'subcategorypostaddajax1', 'uses' => 'SubCategoryController@subcategoryaddajax1']);
	Route::get('a/{data}/details1','SubCategoryController@subcategorydetails');
	
	Route::post('/upload_csv',['as'=>'upload_csv','uses'=>'SubCategoryController@upload_csv1']); // upload third subcategory .csv file
	Route::post('/upload_category_csv',['as'=>'upload_category_csv','uses'=>'CategoryController@upload_category_csv']); // upload category and subcategory .csv file
	Route::post('/upload_business_csv',['as'=>'upload_business_csv','uses'=>'BusinessController@upload_business_csv']); // upload business .csv file
	
	Route::get('subcategory_delete/{rid}','SubCategoryController@subcategorydelete');
	
	Route::get('subadmin1','subadmin1Controller@viewlist');
	Route::get('subadmin1add','subadmin1Controller@addview');
	Route::post('subadmin1postaddajax', [ 'as' => 'subadmin1postaddajax', 'uses' => 'subadmin1Controller@subadmin1postaddajax']);
	Route::get('subadmin1Edit/{id}', ['as' => 'subadmin1Edit', 'uses' => 'subadmin1Controller@subadmin1Edit']);
	Route::post('subadmin1postaddajax1', [ 'as' => 'subadmin1postaddajax1', 'uses' => 'subadmin1Controller@subadmin1postaddajax1']);
	Route::get('subadmin1_delete/{rid}','subadmin1Controller@subadmin1delete');
	
});


// FRONT - NON TRANSLATED
Route::group(['middleware' => ['web', 'geo']], function ($router) {
	
	// AJAX
	Route::group(['prefix' => 'ajax'], function ($router) {
        Route::get('places/countries/{code}/locations', 'Ajax\PlacesController@getLocations');
        Route::get('places/locations/{code}/sub-locations', 'Ajax\PlacesController@getSubLocations');
        Route::get('places/sub-locations/{code}/cities', 'Ajax\PlacesController@getCities');
        Route::post('autocomplete/city', 'Ajax\AutocompleteController@getCities');
        Route::post('category/sub-categories', 'Ajax\CategoryController@getSubCategories');
        Route::post('state/cities', 'Ajax\StateCitiesController@getCities');
        Route::post('save/ad', 'Ajax\AdController@saveAd');
        Route::post('save/search', 'Ajax\AdController@saveSearch');
        Route::get('json/countries.js', 'Ajax\JsonController@getCountries');
        Route::post('ad/phone', 'Ajax\AdController@getPhone');
		Route::post('ajax_add_rating', 'Ajax\AdController@set_rating');
		Route::post('ajax_add_reviews', 'Ajax\AdController@set_reviews');
		
		Route::post('ajax_add_reviews_reply', 'Ajax\AdController@set_reply_for_reviews');
		
		Route::post('ajax_add_fav', 'Ajax\AdController@set_fav');
		Route::post('ajax_remove_fav', 'Ajax\AdController@remove_fav');
		
		Route::post('search/user','Ajax\AutocompleteController@searchUser');
    });
    
    // SEO
    Route::get('robots.txt', 'RobotsController@index');
    Route::get('sitemaps.xml', 'SitemapsController@index');
	
	Route::get('memorytest', 'MemoryTest@fire');
	
	Route::post('report_business','Business\PostController@report_business');
	Route::post('setIpAddress', 'HomeController@setIpAddress');
});


Route::get('cron_google_details', ['as' => 'cron_google_img', 'uses' => 'CronController@getGoogleDetails']);

// FRONT - TRANSLATED
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['local']], function ($router) {
    
	Route::group(['middleware' => ['web', 'geo']], function ($router) {
        Route::get('homevin', 'TestController@test_home');
		Route::get('vtest', 'TestController@vtest');
		Route::get('vdet', 'TestController@vdet');
		Route::get('ins_keyword', 'TestController@ins_keyword');
		Route::post('gotoweb', 'HomeController@setGotoweb'); 
		
		// HOMEPAGE
        Route::group(['middleware' => 'httpCache:yes'], function ($router) {
            //Route::get('/', 'HomeController@maintenance');
			Route::get('/', 'HomeController@index');
			Route::get('events', 'HomeController@events');
			Route::get('offers', 'HomeController@offers');

			Route::get('test_contact','TestController@test_contact');
			
            Route::get('offers/{id}', 'HomeController@offerlist');
			Route::get('events/{id}', 'HomeController@eventlist');
			Route::get('preview/event/{id}', 'HomeController@event_preview');
			Route::get('preview/private/{id}', 'HomeController@private_preview');
			
			/*
			 * Display already uploaded images in Dropzone
			
			Route::get('server-image/{id}', ['as' => 'server-image', 'uses' => 'HomeController@getServerImagesPage']);
			Route::get('server-images', ['as' => 'server-images', 'uses' => 'HomeController@getServerImages']);
			 */
			 
			Route::post('offer-image','HomeController@offer_picture');
			Route::post('offerCompany-logo','HomeController@company_logo');
			Route::post('post-offer', 'HomeController@postOffer');
            Route::get(LaravelLocalization::transRoute('routes.countries'), 'CountriesController@index');
        });
        
        Route::get('vin', function () {
			
		});
		
        // AUTH
        Route::group(['middleware' => ['guest']], function () {
            Route::get(LaravelLocalization::transRoute('routes.signup'), 'Auth\SignupController@getRegister');
            Route::post('signup-post', 'Auth\SignupController@postRegister');
            Route::get('signup/success', 'Auth\SignupController@success');
            Route::get(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@getLogin');
            Route::post('login-post', 'Auth\LoginController@postLogin');
            
            // Activation
            Route::get('user/activation/{token}', 'Auth\SignupController@activation');
            
            // Password reset link request routes...
            Route::get('password/email', 'Auth\PasswordController@getEmail');
            Route::post('password/email', 'Auth\PasswordController@postEmail');
            
            // Password reset routes...
            Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
            Route::post('password/reset', 'Auth\PasswordController@postReset');
            
            // Social Authentication
            Route::get('auth/facebook', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/facebook/callback', 'Auth\SocialController@handleProviderCallback');
            Route::get('auth/google', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/google/callback', 'Auth\SocialController@handleProviderCallback');
            Route::get('auth/twitter', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/twitter/callback', 'Auth\SocialController@handleProviderCallback');
			
			
        });
        Route::get(LaravelLocalization::transRoute('routes.logout'), 'Auth\LoginController@getLogout');
        
        
        // ADS
        /*$router->pattern('id', '[0-9]+');
        Route::get(LaravelLocalization::transRoute('routes.create-ad'), 'Ad\PostController@getForm');
        Route::post('create-ad-post', 'Ad\PostController@postForm');
        Route::get('create-ad/success', 'Ad\PostController@success');
        Route::get('create-ad/success-payment', 'Ad\PostController@getSuccessPayment');
        Route::get('create-ad/cancel-payment', 'Ad\PostController@cancelPayment');
        Route::get('create-ad/activation/{token}', 'Ad\PostController@activation');
        Route::group(['middleware' => 'auth'], function ($router) {
            $router->pattern('id', '[0-9]+');
            Route::get('post/{id}', 'Ad\UpdateController@getForm');
            Route::post('post/{id}', 'Ad\UpdateController@postForm');
            Route::get('post/{id}/success', 'Ad\UpdateController@success');
        });
        Route::get('{title}/{id}.html', 'Ad\DetailsController@index');
        Route::post('{id}/contact', 'Ad\DetailsController@sendMessage');
        Route::post('{id}/report', 'Ad\DetailsController@sendReport');*/
		Route::get('getadsinfo/{id}.html', 'Ad\DetailsController@index');
		
        Route::get('add-business/activation/{token}', 'Business\PostController@activation');
        Route::group(['middleware' => 'auth'], function ($router) {
		
			// Business listing
			$router->pattern('id', '[0-9]+');
			Route::get(LaravelLocalization::transRoute('routes.add-business'), 'Business\PostController@getForm');
			Route::post('add-business-post', 'Business\PostController@postForm');
			Route::get('add-business/success', 'Business\PostController@success');
		
            $router->pattern('id', '[0-9]+');
            Route::get('account/bizinfo/{id}', 'Business\UpdateController@getForm');
            Route::post('account/bizinfo/{id}', 'Business\UpdateController@postForm');
            Route::get('account/bizinfo/{id}/success', 'Business\UpdateController@success');
			
			Route::get('account/bizinfot/{id}', 'Business\TempController@getForm');
            Route::post('account/bizinfot/{id}', 'Business\TempController@postForm');
            Route::get('account/bizinfot/{id}/success', 'Business\TempController@success');
			
			Route::get('account/bizimages/{id}', 'Business\UpdateController@upImages');
			Route::post('account/postbizimages','Business\UpdateController@postImages');
			Route::post('account/delbizimages','Business\UpdateController@delImages');
			
			Route::post('account/postrequestbizimages','Business\UpdateController@postRequestImages');
			Route::post('account/delrequestbizimages','Business\UpdateController@delRequestImages');
			
			Route::get('account/editbiz/{id}', 'Business\UpdateController@getInfoForm');
			Route::post('account/update-business-post','Business\UpdateController@postForm');
			Route::post('account/update-business-info','Business\UpdateController@postInfoForm');
			
			Route::get('account/biziadditional/{id}', 'Business\UpdateController@getAdditionalForm');
			Route::post('account/update-extra-information', 'Business\UpdateController@postAdditionalForm');
			
			Route::get('account/addbizoffer/{id}','Business\UpdateController@addOfferInfo');
			Route::get('account/editbizoffer/{id}','Business\UpdateController@editOfferInfo');
			Route::get('account/{biz_id}/deletebizoffer/{off_id}','Business\UpdateController@deleteOffer');
			Route::post('account/update-offer-post','Business\UpdateController@postOfferInfo');
			
			Route::post('biz_book','Business\UpdateController@updateBooking');
			Route::post('biz_bookTmCheck','Business\UpdateController@biz_bookTmCheck');
			Route::post('book_timeslot','Business\UpdateController@book_timeslot');
			Route::post('find_table','Business\UpdateController@find_table');
			Route::post('book_table','Business\UpdateController@book_table');
			
			Route::get('/biz_gift', ['as' => '/biz_gift', 'uses' => 'Business\UpdateController@updateGifting']);
			Route::get('create/{id}/certificate', 'Business\ExtraController@index');
			Route::post('account/certificate/post', 'Business\ExtraController@postCertificate');
			Route::get('account/certificate/view/{id}', 'Business\ExtraController@viewCertificate');
			
			// Bof Business Location
			Route::get('account/business/location/{id}','Business\ExtraController@getBusinessLocation');
			Route::get('account/business/location/create/{id}','Business\ExtraController@createBusinessLocation');
			Route::post('account/business/location/create','Business\ExtraController@createBusinessLocationPost');
			Route::get('account/business/location/update/{id}','Business\ExtraController@updateBusinessLocation');
			Route::post('account/business/location/update','Business\ExtraController@updateBusinessLocationPost');
			Route::post('account/business/location/delete','Business\ExtraController@deleteBusinessLocation');
			// Eof Business Location
			
			Route::post('post-events', 'HomeController@postevent');
			Route::post('event-image','HomeController@event_picture');
			Route::get('buy/tickets/{id}', 'HomeController@buy_ticket');
			Route::post('buy/tickets/post', 'HomeController@buy_ticket_post');
			Route::get('event/booking/{id}', 'HomeController@event_booking');
			
			Route::get('find_friends','HomeController@find_friends');
			Route::get('messages','HomeController@messages1');
			Route::get('compose_message','HomeController@Compose_messages');
			Route::post('send-compose','HomeController@send_compose_message');
			Route::post('post-friend','HomeController@Search_friend');
			Route::post('send-message','HomeController@send_message');
			Route::post('add-friend','HomeController@add_friend');
			Route::get('friendRequest/activation/{token}', 'HomeController@activation');
			Route::get('friends-confirm','HomeController@friends_confirm');
			Route::post('accept-friend','HomeController@accept_friend');
			Route::get('view-message/{message_id}', 'HomeController@reply');
			Route::post('message-reply','HomeController@message_reply');
			Route::post('drop-messages','HomeController@delete_messages');
			Route::get('yahoo-contact','HomeController@getYahooContacts');
			Route::post('invite-friends','HomeController@InviteFriends');
			Route::get('friends-lists/{id}','HomeController@friend_lists');
			
			Route::get('/redirect/{title}/{id}', function ($title,$id) {
				// redirect to the business page
				return redirect()->action('Business\DetailsController@index', ['id' => $id, 'title' => $title]);
			});
			
			Route::get('/event/auth/check', function () {
				// redirect to the event post page
				return redirect()->action('HomeController@events');
			});
			
			Route::get('profiles/{id}','HomeController@profiles');
			Route::post('profiles/upload/cover','HomeController@uploadCover');
			Route::post('profiles/remove/cover','HomeController@removeCover');
			
			Route::post('msg/read','HomeController@messageReadAjax');
        });
		
		/* Route::get('business/transfer/bus','Business\ExtraController@transferBus'); */
		
		Route::post('city/autogenerate', 'HomeController@getCityAjax');
		
        Route::get('sendcertificates/{id}', 'Business\ExtraController@sendCertificateMail');
        //Route::get('sendcertificate/{id}', 'Business\ExtraController@sendCertificate');
        Route::get('pic2pdf', 'Business\ExtraController@picTwoPdf');
			
		Route::get('find/business', 'Business\ExtraController@findBusiness');
        
        Route::get('{title}/{id}.html', 'Business\DetailsController@index');
        
        Route::post('{id}/contact', 'Business\DetailsController@sendMessage');
        Route::post('{id}/report', 'Business\DetailsController@sendReport');
        Route::post('/set_back', 'Business\DetailsController@setBack');
		Route::post('place/reviews', 'Business\DetailsController@postReviews');
		
		Route::post('change/business/location/ajax', 'Business\DetailsController@bizLocAjax');
			
		Route::post('keywords',['as'=>'keywords','uses'=>'Business\PostController@keywords']);
		
		/* TEST API */
		/* Route::get('/existOrNot','TestApiController@existOrNot');
		Route::post('/existOrNot','TestApiController@existOrNot');
		
		Route::get('/ifNeedList','TestApiController@ifNeedList');
		Route::post('/ifNeedList','TestApiController@ifNeedList'); */
		
		Route::match(['get', 'post'], '/checkConnection', ['uses' => 'TestApiController@existOrNot']);
		Route::match(['get', 'post'], '/matchConnection', ['uses' => 'TestApiController@ifNeedList']);
		
        // ACCOUNT
        Route::group(['middleware' => 'auth', 'namespace' => 'Account'], function ($router) {
            $router->pattern('id', '[0-9]+');
            
            Route::get('account', 'HomeController@index');
			Route::get('account/edit', 'HomeController@edit_account');
            Route::post('account/details', 'EditController@details');
			
            Route::put('account/settings/update', 'EditController@settings');
            Route::put('account/dp_settings/update', 'EditController@dp_update');
            Route::post('account/dp_settings/delete', 'EditController@dp_delete');
            Route::put('account/in_settings/update', 'EditController@in_settings');
			Route::put('account/pr_settings/update', 'EditController@pr_settings');
			Route::put('account/en_settings/update', 'EditController@en_settings');
            
            Route::post('account/preferences', 'EditController@preferences');
            Route::get('account/home', 'HomeController@index');
            
            Route::get('account/myevents', 'HomeController@getMyEvents');
            Route::get('account/myevents/edit/{id}', 'HomeController@editMyEvents');
            Route::post('account/myevents/post', 'HomeController@postMyEvents');
            Route::get('account/myevents/delete/{id}', 'HomeController@deleteMyEvents');
            Route::post('account/myevents/edit/myevent-image','HomeController@myevent_picture');
			
            Route::get('account/mycertificateorders','HomeController@getMyCertificateOrders');
            Route::get('account/myeventorders','HomeController@getMyEventOrders');
            
            Route::get('account/myads', 'AdsController@getMyAds');
			Route::get('account/mybusinesslistings', 'BusinessController@getMyBusiness');
            Route::get('account/archived', 'AdsController@getArchivedAds');
            Route::get('account/favourite', 'AdsController@getFavouriteAds');
            //Route::get('account/pending-approval', 'AdsController@getPendingApprovalAds');
			Route::get('account/pending-approval', 'BusinessController@getPendingApproval');
			
            Route::get('account/saved-search', 'AdsController@getSavedSearch');
            Route::get('account/close', 'CloseController@index');
            Route::post('account/close', 'CloseController@submit');
            
            $router->pattern('segment', '(mybusinesslistings|archived|favourite|pending-approval|saved-search)+');
            
            // Route::get('account/archived/repost/{id}', 'AdsController@getArchivedAds');
            Route::get('account/{segment}/delete/{id}', 'BusinessController@delete');
            Route::post('account/{segment}/delete', 'BusinessController@delete');
			
			//BOF Reservation Section
			//Route::get('account/biz/{id}/booking/settings', 'BusinessController@settings');
			Route::get('account/businessbooking/{id}','BusinessController@getMyBusinessBooking');
			Route::get('account/mybusinessorders','BusinessController@getMyBusinessOrders');
			Route::post('account/book_action','BusinessController@book_action');
			//EOF Reservation Section
			
			// Bof Activity Graph
			Route::get('account/business/graph','HomeController@getBusinessGraph');
			Route::get('account/business/graph/day/{id}','HomeController@getBusinessGraphDay');
			Route::get('account/business/graph/month/{id}','HomeController@getBusinessGraphMonth');
			
			Route::get('account/event/graph','HomeController@getEventGraph');
			Route::get('account/event/graph/day/{id}','HomeController@getEventGraphDay');
			Route::get('account/event/graph/month/{id}','HomeController@getEventGraphMonth');
			// Eof Activity Graph
        });


        // Country Code Pattern
        $countries = new \Larapen\CountryLocalization\Helpers\Country();
        $country_code_pattern = implode('|', array_map('strtolower', array_keys($countries->all())));
        $router->pattern('countryCode', $country_code_pattern);


        // STATICS PAGES
        Route::group(['middleware' => 'httpCache:yes'], function ($router) {
            Route::get(LaravelLocalization::transRoute('routes.about'), 'PageController@about');
            Route::get(LaravelLocalization::transRoute('routes.contact'), 'PageController@contact');
            Route::post(LaravelLocalization::transRoute('routes.contact'), 'PageController@contactPost');
            Route::get(LaravelLocalization::transRoute('routes.faq'), 'PageController@faq');
            //Route::get(LaravelLocalization::transRoute('routes.phishing'), 'PageController@phishing');
            Route::get(LaravelLocalization::transRoute('routes.anti-scam'), 'PageController@antiScam');
            //Route::get(LaravelLocalization::transRoute('routes.sitemap'), 'SitemapController@index');
            Route::get(LaravelLocalization::transRoute('routes.terms'), 'PageController@terms');
            Route::get(LaravelLocalization::transRoute('routes.privacy'), 'PageController@privacy');
			//Route::get(LaravelLocalization::transRoute('routes.advertise'), 'PageController@advertise');
			Route::get(LaravelLocalization::transRoute('routes.guidelines'), 'PageController@guidelines');
			Route::get(LaravelLocalization::transRoute('routes.press'), 'PageController@press');
			
        });

        Route::get('c/{slug}', 'Business\DetailsController@plist');
        Route::get('list', 'Business\DetailsController@productList');
		Route::get('map/{id}', 'Business\DetailsController@map');
		Route::get('claim/{id}', 'Business\DetailsController@claim');
		Route::post('claimpost', 'Business\DetailsController@claimpost');
		//Route::get('{countryCode}/{catTitle}', 'Business\DetailsController@plist');
		
        // SEO
        Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
        Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
        Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
        Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
        Route::get('{countryCode}/sitemaps/ads.xml', 'SitemapsController@ads');
        
        
        // DYNAMIC URL PAGES
        $router->pattern('id', '[0-9]+');
        Route::get(LaravelLocalization::transRoute('routes.search'), 'SearchController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-user'), 'SearchController@user');
        Route::get(LaravelLocalization::transRoute('routes.search-location'), 'SearchController@location');
        Route::get('{countryCode}/{country}/{catTitle}', 'SearchController@category');
        Route::get('{countryCode}/{country}/{catTitle}/{subCatTitle}', 'SearchController@subCategory');
        
		Route::get('{countryCode}/googlesearch', 'SearchGoogleController@index');
        /*
		 * Display already uploaded images in Dropzone
		 */
		Route::get('example-2', ['as' => 'upload-2', 'uses' => 'ImageController@getServerImagesPage']);
		Route::get('server-images', ['as' => 'server-images', 'uses' => 'ImageController@getServerImages']);
        
    });
});
	
	
/* BOF API ROUTES */

	// Auth routes...
	Route::post('api/login', ['as'=>'api_login','uses'=>'Api\AuthController@PostLogin']);
	Route::get('api/register/load', ['as'=>'api_register_load','uses'=>'Api\AuthController@GetRegister']);
	Route::post('api/register', ['as'=>'api_register','uses'=>'Api\AuthController@PostRegister']);
	Route::post('api/forgot', ['as'=>'api_forgot','uses'=>'Api\AuthController@ForgotPassword']);
	Route::post('api/password', ['as'=>'api_password','uses'=>'Api\AuthController@ChangePassword']);

	// Main routes...
	// April
	Route::get('api/check', ['as'=>'api_check','uses'=>'Api\MainController@CheckGCM']);
	Route::post('api/update_gcm', ['as'=>'update_gcm','uses'=>'Api\MainController@UpdateGcmToken']);
	Route::post('api/update_location', ['as'=>'update_location','uses'=>'Api\MainController@UpdateUserLocation']);
	
	Route::get('api/test/dashboard', ['as'=>'api_test_dashboard','uses'=>'Api\MainController@TestDashboard']);
	Route::get('api/dashboard', ['as'=>'api_dashboard','uses'=>'Api\MainController@GetDashboard']);
	
	Route::get('api/profile/load', ['as'=>'api_profile_load','uses'=>'Api\MainController@GetProfile']);
	Route::post('api/profile', ['as'=>'api_profile','uses'=>'Api\MainController@PostProfile']);
	Route::post('api/upload/profile/picture', ['as'=>'api_upload_profile_picture','uses'=>'Api\MainController@UploadProfilePicture']);
	
	Route::get('api/events/own', ['as'=>'api_events_own','uses'=>'Api\MainController@GetOwnEvent']);
	Route::get('api/events/single', ['as'=>'api_events_single','uses'=>'Api\MainController@GetSingleEvent']);
	Route::get('api/events/upcome', ['as'=>'api_events_upcome','uses'=>'Api\MainController@GetUpcomeEvent']);
	Route::get('api/events/popular', ['as'=>'api_events_popular','uses'=>'Api\MainController@GetPopularEvent']);
	
	Route::get('api/events/book/load', ['as'=>'api_events_book_load','uses'=>'Api\MainController@BookEvents']);
	Route::post('api/events/book/post', ['as'=>'api_events_book_post','uses'=>'Api\MainController@BookEventsPost']);
	
	Route::get('api/business/own', ['as'=>'api_business_own','uses'=>'Api\MainController@GetBusinessOwn']);
	Route::get('api/business/all', ['as'=>'api_business_all','uses'=>'Api\MainController@GetBusinessAll']);
	Route::get('api/business/allt', ['as'=>'api_business_allt','uses'=>'Api\MainController@GetBusinessAllT']);
	Route::get('api/business/allnew', ['as'=>'api_business_all','uses'=>'Api\MainController@GetBusinessAllnew']);
	Route::get('api/business/search', ['as'=>'api_business_search','uses'=>'Api\MainController@SearchBusiness']);
	Route::get('api/business/single', ['as'=>'api_business_single','uses'=>'Api\MainController@GetBusinessSingle']);
	Route::get('api/business/reviews', ['as'=>'api_business_reviews','uses'=>'Api\MainController@GetBusinessReviews']);
	Route::get('api/business/locate', ['as'=>'api_business_locate','uses'=>'Api\MainController@GetBusinessLocate']);
	Route::get('api/pending/business', ['as'=>'api_pending_business','uses'=>'Api\MainController@GetPendingBusiness']);
	Route::get('api/category/business', ['as'=>'api_category_business','uses'=>'Api\MainController@GetBusinessByCategory']);
	Route::post('api/business/status', ['as'=>'api_business_status','uses'=>'Api\MainController@BusinessStatusChangeAction']);
	Route::post('api/business/report', ['as'=>'api_business_report','uses'=>'Api\MainController@ReportBusiness']);
	
	Route::get('api/create/event/load', ['as'=>'api_create_event_load','uses'=>'Api\MainController@GetCreateEvent']);
	Route::post('api/create/event', ['as'=>'api_create_event_post','uses'=>'Api\MainController@PostCreateEvent']);
	Route::get('api/update/event/load', ['as'=>'api_update_event_load','uses'=>'Api\MainController@GetUpdateEvent']);
	Route::post('api/update/event', ['as'=>'api_update_event_post','uses'=>'Api\MainController@PostUpdateEvent']);
	Route::post('api/delete/event', ['as'=>'api_delete_event_post','uses'=>'Api\MainController@PostDeleteEvent']);
	Route::post('api/upload/event/image', ['as'=>'api_upload_event_image','uses'=>'Api\MainController@UploadEventImage']);
	
	Route::get('api/create/business/load', ['as'=>'api_create_business_load','uses'=>'Api\MainController@GetCreateBusiness']);
	Route::post('api/create/business', ['as'=>'api_create_business_post','uses'=>'Api\MainController@PostCreateBusiness']);
	Route::get('api/update/business/load', ['as'=>'api_update_business_load','uses'=>'Api\MainController@GetUpdateBusiness']);
	Route::post('api/update/business', ['as'=>'api_update_business_post','uses'=>'Api\MainController@PostUpdateBusiness']);
	Route::post('api/update/business/hours', ['as'=>'api_update_business_hours','uses'=>'Api\MainController@PostUpdateBusinessHours']);
	Route::post('api/update/business/infos', ['as'=>'api_update_business_infos','uses'=>'Api\MainController@PostUpdateBusinessInfos']);
	Route::post('api/update/business/basic', ['as'=>'api_update_business_basic','uses'=>'Api\MainController@PostUpdateBusinessBasic']);
	Route::post('api/delete/business', ['as'=>'api_delete_business_post','uses'=>'Api\MainController@PostDeleteBusiness']);
	Route::post('api/upload/business/image', ['as'=>'api_upload_business_image','uses'=>'Api\MainController@UploadBusinessImage']);
	
	Route::get('api/create/certificate/load', ['as'=>'api_create_gift_certificate_load','uses'=>'Api\MainController@GetCreateCertificate']);
	Route::post('api/create/certificate', ['as'=>'api_create_gift_certificate_post','uses'=>'Api\MainController@PostCreateCertificate']);
	Route::get('api/send/certificate/{id}', ['as'=>'api_send_gift_certificate_get','uses'=>'Api\MainController@GetSendCertificate']);
	
	Route::get('api/create/offer/load', ['as'=>'api_create_offer_load','uses'=>'Api\MainController@GetCreateOffer']);
	Route::post('api/create/offer', ['as'=>'api_create_offer_post','uses'=>'Api\MainController@PostCreateOffer']);
	Route::get('api/update/offer/load', ['as'=>'api_update_offer_load','uses'=>'Api\MainController@GetUpdateOffer']);
	Route::post('api/update/offer', ['as'=>'api_update_offer_post','uses'=>'Api\MainController@PostUpdateOffer']);
	Route::post('api/delete/offer', ['as'=>'api_delete_offer_post','uses'=>'Api\MainController@PostDeleteOffer']);
	
	Route::get('api/reservation/timeslot/load', ['as'=>'api_reserve_timeslot_load','uses'=>'Api\MainController@GetReserveTimeSlot']);
	Route::post('api/reserve/timeslot', ['as'=>'api_reserve_timeslot','uses'=>'Api\MainController@PostReserveTimeSlot']);
	
	Route::get('api/reservation/load', ['as'=>'api_reservation_load','uses'=>'Api\MainController@GetReserveTable']);
	Route::post('api/reserve/table/check', ['as'=>'api_reserve_table_check','uses'=>'Api\MainController@CheckReserveTable']);
	Route::post('api/reserve/table', ['as'=>'api_reserve_table','uses'=>'Api\MainController@PostReserveTable']);
	
	Route::get('api/own/business/booking', ['as'=>'api_own_business_booking','uses'=>'Api\MainController@GetOwnBusinessBooking']);
	Route::get('api/own/events/booking', ['as'=>'api_own_events_booking','uses'=>'Api\MainController@GetOwnEventsBooking']);
	Route::get('api/own/events/status', ['as'=>'api_own_events_status','uses'=>'Api\MainController@EventStatusChangeAction']);
	Route::get('api/own/gift/purchases', ['as'=>'api_own_gift_purchases','uses'=>'Api\MainController@GetOwnGiftPurchases']);
	
	Route::get('api/business/booking', ['as'=>'api_my_business_booking','uses'=>'Api\MainController@GetMyBusinessBooking']);
	Route::get('api/events/booking', ['as'=>'api_my_events_booking','uses'=>'Api\MainController@GetMyEventsBooking']);
	Route::get('api/gift/purchases', ['as'=>'api_my_gift_purchases','uses'=>'Api\MainController@GetMyGiftPurchases']);
	
	Route::post('api/generate/country', ['as'=>'api_generate_country','uses'=>'Api\MainController@GenerateCountry']);
	Route::post('api/generate/location', ['as'=>'api_generate_location','uses'=>'Api\MainController@GenerateLocation']);
	Route::post('api/generate/city', ['as'=>'api_generate_city','uses'=>'Api\MainController@GenerateCity']);
	Route::post('api/generate/keyword', ['as'=>'api_generate_keyword','uses'=>'Api\MainController@GenerateKeyword']);
	
	Route::post('api/biz/booking/status', ['as'=>'api_biz_booking_status','uses'=>'Api\MainController@BizBookingStatus']);
	Route::get('api/biz/booking/edit', ['as'=>'api_biz_booking_edit','uses'=>'Api\MainController@BizBookingEdit']);
	Route::post('api/biz/time/booking/edit', ['as'=>'api_biz_time_booking_edit','uses'=>'Api\MainController@BizTimeBookingEdit']);
	Route::post('api/biz/table/booking/edit', ['as'=>'api_biz_table_booking_edit','uses'=>'Api\MainController@BizTableBookingEdit']);

	Route::post('api/post/review', ['as'=>'api_post_review','uses'=>'Api\MainController@PostReview']);
	   
	Route::get('api/users/list', ['as'=>'api_users_list','uses'=>'Api\MainController@ListOfUsers']);
	Route::get('api/users/reviewlist', ['as'=>'api_review_list','uses'=>'Api\MainController@ReviewsList']);
	Route::get('api/users/activitylist', ['as'=>'api_activity_list','uses'=>'Api\MainController@ActivityList']);
	Route::get('api/users/intrestlist', ['as'=>'api_intrest_list','uses'=>'Api\MainController@UserIntrests']);
	Route::get('api/users/notifications_all', ['as'=>'api_notifications_list','uses'=>'Api\MainController@NotificationsAll']);
	
	Route::get('api/messages/list', ['as'=>'api_messages_list','uses'=>'Api\MainController@ListOfMessages']);
	Route::get('api/messages/view', ['as'=>'api_messages_view','uses'=>'Api\MainController@ViewOfMessages']);
	Route::post('api/messages/send', ['as'=>'api_messages_Send','uses'=>'Api\MainController@SendMessages']);
	Route::post('api/messages/reply', ['as'=>'api_messages_reply','uses'=>'Api\MainController@ReplyOfMessages']);
	Route::post('api/messages/delete', ['as'=>'api_messages_delete','uses'=>'Api\MainController@DeleteMessages']);
	
	Route::get('api/business/graph', ['as'=>'api_business_graph','uses'=>'Api\MainController@BusinessGraph']);
	//Route::post('api/business/graph/view', ['as'=>'api_business_graph_month','uses'=>'Api\MainController@BusinessGraphView']);
	Route::post('api/business/graph/viewA', ['as'=>'api_business_graph_month','uses'=>'Api\MainController@BusinessGraphViewA']);
	
	Route::get('api/event/graph', ['as'=>'api_event_graph','uses'=>'Api\MainController@EventGraph']);
	//Route::post('api/event/graph/view', ['as'=>'api_event_graph_month','uses'=>'Api\MainController@EventGraphView']);
	Route::post('api/event/graph/viewA', ['as'=>'api_event_graph_month','uses'=>'Api\MainController@EventGraphViewA']);
	
	Route::post('api/friends', ['as'=>'api_friends','uses'=>'Api\MainController@FriendList']);
	Route::post('api/friends/manage', ['as'=>'api_friends_manage','uses'=>'Api\MainController@FriendListManage']);
	//Route::post('api/friends/manage', ['as'=>'api_friends_manage','uses'=>'Api\MainController@FriendManage']);
	
	Route::get('api/find/friends', ['as'=>'api_find_friends','uses'=>'Api\MainController@FindFriends']);
	Route::post('api/invite/friends', ['as'=>'api_invite_friends','uses'=>'Api\MainController@InviteFriends']);
	
	Route::get('api/notifications', ['as'=>'api_notifications','uses'=>'Api\MainController@Notifications']);
	
	Route::post('api/update/country', ['as'=>'api_update_country','uses'=>'Api\MainController@UpdateCountry']);
	
	Route::get('api/mail/compose', ['as'=>'api_compose','uses'=>'Api\MainController@MailCompose']);
	
/* EOF API ROUTES */
	