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
    CRUD::resource('category', 'CategoryController');
   // CRUD::resource('subcategory', 'SubCategoryController');
    //CRUD::resource('picture', 'PictureController');
	CRUD::resource('business-image-request', 'BusinessImageRequestController');
	CRUD::resource('business-image', 'BusinessImageController');
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
    CRUD::resource('report_type', 'ReportTypeController');
    CRUD::resource('blacklist', 'BlacklistController');
    CRUD::resource('country', 'CountryController');
	CRUD::resource('city', 'CityController');
	Route::post('subadmin',['as'=>'subadmin','uses'=>'CityController@country_code']);
	Route::post('location',['as'=>'location','uses'=>'CityController@locationpost']);
	//Route::post('keywords',['as'=>'keywords','uses'=>'BusinessController@keywords']);
	Route::post('getlocation',['as'=>'getlocation','uses'=>'BusinessController@location']);
	Route::post('getcity',['as'=>'getcity','uses'=>'BusinessController@city']);
	Route::post('imgaction',['as'=>'imgaction','uses'=>'BusinessImageRequestController@imgaction']);
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
	Route::post('subcat',['as'=>'subcat','uses'=>'SubCategoryController@subcategorypost']);
	Route::post('subcategorypostaddajax', [ 'as' => 'subcategorypostaddajax', 'uses' => 'SubCategoryController@subcategoryaddajax']);
	Route::get('subcategoryEdit/{id}', ['as' => 'subcategoryEdit', 'uses' => 'SubCategoryController@subcategoryEdit']);
	Route::get('subcategoryEdit1/{lang}/{id}', ['as' => 'subcategoryEdit1', 'uses' => 'SubCategoryController@subcategoryEditlang']);
	
	Route::post('subcategorytanslate', [ 'as' => 'subcategorytanslate', 'uses' => 'SubCategoryController@subcategoryaddajax1lang']);
	Route::post('subcategorypostaddajax1', [ 'as' => 'subcategorypostaddajax1', 'uses' => 'SubCategoryController@subcategoryaddajax1']);
	Route::get('a/{data}/details1','SubCategoryController@subcategorydetails');
	
	Route::post('/upload_csv',['as'=>'upload_csv','uses'=>'SubCategoryController@upload_csv1']); // upload third subcategory .csv file
	Route::post('/upload_category_csv',['as'=>'upload_category_csv','uses'=>'CategoryController@upload_category_csv']); // upload category and subcategory .csv file
	
	
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
		
    });
    
    // SEO
    Route::get('robots.txt', 'RobotsController@index');
    Route::get('sitemaps.xml', 'SitemapsController@index');
	
	Route::get('memorytest', 'MemoryTest@fire');
	
});


// FRONT - TRANSLATED
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['local']], function ($router) {
    Route::group(['middleware' => ['web', 'geo']], function ($router) {
        // HOMEPAGE
        Route::group(['middleware' => 'httpCache:yes'], function ($router) {
			
            //Route::get('/', 'HomeController@maintenance');
			Route::get('/', 'HomeController@index');
			Route::get('events', 'HomeController@events');
			Route::get('offers', 'HomeController@offers');
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
			Route::get('yahoo-contact','HomeController@getYahooContacts');
			Route::post('invite-friends','HomeController@InviteFriends');
			
			Route::get('test_contact','TestController@test_contact');
			
			
            Route::get('offers/{id}', 'HomeController@offerlist');
			Route::get('events/{id}', 'HomeController@eventlist');
			Route::get('preview/event/{id}', 'HomeController@event_preview');
			Route::get('preview/private/{id}', 'HomeController@private_preview');
			Route::post('post-events', 'HomeController@postevent');
			Route::post('event-image','HomeController@event_picture');
			Route::get('buy/tickets/{id}', 'HomeController@buy_ticket');
			Route::post('buy/tickets/post', 'HomeController@buy_ticket_post');
			Route::get('event/booking/{id}', 'HomeController@event_booking');
			
			Route::get('profiles/{id}','HomeController@profiles');
				
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
			
			
        });
        
        Route::get('sendcertificates/{id}', 'Business\ExtraController@sendCertificateMail');
        //Route::get('sendcertificate/{id}', 'Business\ExtraController@sendCertificate');
        Route::get('pic2pdf', 'Business\ExtraController@picTwoPdf');
        
        Route::get('{title}/{id}.html', 'Business\DetailsController@index');
        
        Route::post('{id}/contact', 'Business\DetailsController@sendMessage');
        Route::post('{id}/report', 'Business\DetailsController@sendReport');
        Route::post('/set_back', 'Business\DetailsController@setBack');
		Route::post('place/reviews', 'Business\DetailsController@postReviews');
			
		Route::post('keywords',['as'=>'keywords','uses'=>'Business\PostController@keywords']);
		Route::get('/getoffers',['as'=>'/getoffers','uses'=>'Business\PostController@offers']);
		
        // ACCOUNT
        Route::group(['middleware' => 'auth', 'namespace' => 'Account'], function ($router) {
            $router->pattern('id', '[0-9]+');
            
            Route::get('account', 'HomeController@index');
			Route::get('account/edit', 'HomeController@edit_account');
            Route::post('account/details', 'EditController@details');
			
            Route::put('account/settings/update', 'EditController@settings');
            Route::put('account/dp_settings/update', 'EditController@dp_settings');
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
		Route::get('map/{id}', 'Business\DetailsController@map');
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
        
        /*
		 * Display already uploaded images in Dropzone
		 */
		Route::get('example-2', ['as' => 'upload-2', 'uses' => 'ImageController@getServerImagesPage']);
		Route::get('server-images', ['as' => 'server-images', 'uses' => 'ImageController@getServerImages']);
        
    });
});
