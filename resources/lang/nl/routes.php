<?php
/**
 * Created by PhpStorm.
 * User: mayeul
 * Date: 24/02/2016
 * Time: 21:41
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Routes Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the global website.
    |
    */
    
    'countries' => 'countries',
    
    'login' => 'login',
    'logout' => 'logout',
    'signup' => 'signup',
    'create-ad' => 'create-ad',
    
    'about' => 'about.html',
    'contact' => 'contact.html',
    'faq' => 'faq.html',
    'phishing' => 'phishing.html',
    'anti-scam' => 'anti-scam.html',
    'terms' => 'terms.html',
    'privacy' => 'privacy.html',
    'sitemap' => '{countryCode}/sitemap.html',
    'v-sitemap' => ':country_code/sitemap.html',
    
    'search' => '{countryCode}/search',
    't-search' => 'search',
    'v-search' => ':country_code/search',
    
    'search-location' => '{countryCode}/free-ads/{title}/{id}',
    't-search-location' => 'free-ads',
    'v-search-location' => ':country_code/free-ads/:title/:id',
    
    'search-user' => '{countryCode}/search/user/{id}',
    't-search-user' => 'search/user',
    'v-search-user' => ':country_code/search/user/:id',

];