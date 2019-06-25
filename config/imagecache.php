<?php

return array(
    
    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    | 
    | {route}/{template}/{filename}
    | 
    | Examples: "images", "img/cache"
    |
    */
    
    'route' => "pic/x/cache",
    
    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited 
    | by URI. 
    | 
    | Define as many directories as you like.
    |
    */
    
    'paths' => array(
        public_path('/'), //=> {host}/pic/x/cache/{size}/uploads/pictures/{countryCode}/{id}/{filename}
        public_path('uploads/app'),
        public_path('uploads/app/categories'),
        public_path('uploads/app/logo'),
        public_path('uploads/pictures'),
        public_path('uploads/resumes'),
        public_path('images'),
    ),
    
    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates 
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */
    
    'templates' => array(
        /*
        'small' => 'Intervention\Image\Templates\Small',
        'medium' => 'Intervention\Image\Templates\Medium',
        'large' => 'Intervention\Image\Templates\Large',
        */
        'small' => 'App\Larapen\Filters\Image\Small',
        'medium' => 'App\Larapen\Filters\Image\Medium',
        'big' => 'App\Larapen\Filters\Image\Big',
        'large' => 'App\Larapen\Filters\Image\Large',
        
        'logo' => 'App\Larapen\Filters\Image\Logo',
        'logo2x' => 'App\Larapen\Filters\Image\Logo2x',
    ),
    
    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */
    
    'lifetime' => 43200,

);
