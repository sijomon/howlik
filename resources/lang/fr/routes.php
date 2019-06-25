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
    
    'countries' => 'pays',
    
    'login' => 'connexion',
    'logout' => 'deconnexion',
    'signup' => 'inscription',
    'create-ad' => 'creer-annonce',
    
    'about' => 'apropos.html',
    'contact' => 'contact.html',
    'faq' => 'faq.html',
    'phishing' => 'usurpation-d-identite.html',
    'anti-scam' => 'anti-arnaque.html',
    'terms' => 'conditions.html',
    'privacy' => 'vie-privee.html',
    'sitemap' => '{countryCode}/plan-du-site.html',
    'v-sitemap' => ':country_code/plan-du-site.html',
    
    'search' => '{countryCode}/recherche',
    't-search' => 'recherche',
    'v-search' => ':country_code/recherche',
    
    'search-location' => '{countryCode}/petites-annonces/{title}/{id}',
    't-search-location' => 'petites-annonces',
    'v-search-location' => ':country_code/petites-annonces/:title/:id',
    
    'search-user' => '{countryCode}/recherche/vendeur/{id}',
    't-search-user' => 'recherche/vendeur',
    'v-search-user' => ':country_code/recherche/vendeur/:id',

];