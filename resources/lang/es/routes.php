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
    
    'countries' => 'paises',
    
    'login' => 'login',
    'logout' => 'cerrar-sesion',
    'signup' => 'registrate',
    'create-ad' => 'crear-anuncio',
    
    'about' => 'sobre-nosotros.html',
    'contact' => 'contacto.html',
    'faq' => 'faq.html',
    'phishing' => 'suplantacion-de-identidad.html',
    'anti-scam' => 'anti-estafa.html',
    'terms' => 'condiciones.html',
    'privacy' => 'vida-privada.html',
    'sitemap' => '{countryCode}/mapa-del-sitio.html',
    'v-sitemap' => ':country_code/mapa-del-sitio.html',
    
    'search' => '{countryCode}/busqueda',
    't-search' => 'busqueda',
    'v-search' => ':country_code/busqueda',
    
    'search-location' => '{countryCode}/anuncios-gratuitos/{title}/{id}',
    't-search-location' => 'anuncios-gratuitos',
    'v-search-location' => ':country_code/anuncios-gratuitos/:title/:id',
    
    'search-user' => '{countryCode}/busqueda/vendedor/{id}',
    't-search-user' => 'busqueda/vendedor',
    'v-search-user' => ':country_code/busqueda/vendedor/:id',

];