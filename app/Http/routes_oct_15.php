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
    CRUD::resource('ad', 'AdController');
    CRUD::resource('category', 'CategoryController');
   // CRUD::resource('subcategory', 'SubCategoryController');
    CRUD::resource('picture', 'PictureController');
    CRUD::resource('ad_type', 'AdTypeController');
	CRUD::resource('offers', 'offerController');
	CRUD::resource('reviews', 'AdReviewController');
    CRUD::resource('user', 'UserController');
    CRUD::resource('gender', 'GenderController');
    CRUD::resource('advertising', 'AdvertisingController');
    CRUD::resource('pack', 'PackController');
    CRUD::resource('payment', 'PaymentController');
    CRUD::resource('report_type', 'ReportTypeController');
    CRUD::resource('blacklist', 'BlacklistController');
    CRUD::resource('country', 'CountryController');
    CRUD::resource('currency', 'CurrencyController');
    CRUD::resource('time_zone', 'TimeZoneController');
    CRUD::resource('event', 'EventController');
    CRUD::resource('deal', 'DealController');
    CRUD::resource('cms', 'CmsController');
    Route::get('account', 'UserController@account');
	Route::get('reviews_det/{tid}', 'AdReviewController@detail');
	Route::get('review_delete/{rid}','AdReviewController@reviewdelete');
	Route::get('subcategory',['as'=>'subcategory','uses'=>'SubCategoryController@viewlist']);
	Route::get('subcategoryadd','SubCategoryController@add1');
	Route::post('subcat','SubCategoryController@subcategorypost');
	Route::post('subcategorypostaddajax', [ 'as' => 'subcategorypostaddajax', 'uses' => 'SubCategoryController@subcategoryaddajax']);
	Route::get('subcategoryEdit/{id}', ['as' => 'subcategoryEdit', 'uses' => 'SubCategoryController@subcategoryEdit']);
	Route::get('subcategoryEdit1/{lang}/{id}', ['as' => 'subcategoryEdit1', 'uses' => 'SubCategoryController@subcategoryEditlang']);
	
	Route::post('subcategorytanslate', [ 'as' => 'subcategorytanslate', 'uses' => 'SubCategoryController@subcategoryaddajax1lang']);
	Route::post('subcategorypostaddajax1', [ 'as' => 'subcategorypostaddajax1', 'uses' => 'SubCategoryController@subcategoryaddajax1']);
	Route::get('a/{data}/details1','SubCategoryController@subcategorydetails');
	Route::get('subcategory_delete/{rid}','SubCategoryController@subcategorydelete');
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
    });
    
    // SEO
    Route::get('robots.txt', 'RobotsController@index');
    Route::get('sitemaps.xml', 'SitemapsController@index');
    
});

// FRONT - TRANSLATED
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['local']], function ($router) {
    Route::group(['middleware' => ['web', 'geo']], function ($router) {
        // HOMEPAGE
        Route::group(['middleware' => 'httpCache:yes'], function ($router) {
            Route::get('/', 'HomeController@index');
			Route::get('events', 'HomeController@events');
			Route::get('offers', 'HomeController@offers');
            Route::get(LaravelLocalization::transRoute('routes.countries'), 'CountriesController@index');
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
        $router->pattern('id', '[0-9]+');
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
        Route::post('{id}/report', 'Ad\DetailsController@sendReport');
        
        
        // ACCOUNT
        Route::group(['middleware' => 'auth', 'namespace' => 'Account'], function ($router) {
            $router->pattern('id', '[0-9]+');
            
            Route::get('account', 'HomeController@index');
            Route::post('account/details', 'EditController@details');
			
			 
            
            //Route::get('account/settings/update', 'EditController@details');
            Route::put('account/settings/update', 'EditController@settings');
            
            Route::post('account/preferences', 'EditController@preferences');
            Route::get('account/home', 'HomeController@index');
            Route::get('account/myads', 'AdsController@getMyAds');
            Route::get('account/archived', 'AdsController@getArchivedAds');
            Route::get('account/favourite', 'AdsController@getFavouriteAds');
            Route::get('account/pending-approval', 'AdsController@getPendingApprovalAds');
            Route::get('account/saved-search', 'AdsController@getSavedSearch');
            Route::get('account/close', 'CloseController@index');
            Route::post('account/close', 'CloseController@submit');
            
            $router->pattern('segment', '(myads|archived|favourite|pending-approval|saved-search)+');
            
            Route::get('account/archived/repost/{id}', 'AdsController@getArchivedAds');
            Route::get('account/{segment}/delete/{id}', 'AdsController@delete');
            Route::post('account/{segment}/delete', 'AdsController@delete');
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
            Route::get(LaravelLocalization::transRoute('routes.phishing'), 'PageController@phishing');
            Route::get(LaravelLocalization::transRoute('routes.anti-scam'), 'PageController@antiScam');
            Route::get(LaravelLocalization::transRoute('routes.sitemap'), 'SitemapController@index');
            Route::get(LaravelLocalization::transRoute('routes.terms'), 'PageController@terms');
            Route::get(LaravelLocalization::transRoute('routes.privacy'), 'PageController@privacy');
			Route::get(LaravelLocalization::transRoute('routes.advertise'), 'PageController@advertise');
			Route::get(LaravelLocalization::transRoute('routes.press'), 'PageController@press');
			
        });

        
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
        
    });
});
