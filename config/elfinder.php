<?php

return array(
    
    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */
    'dir' => ['uploads'],
    
    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => env('APP_URL') . '/to/disk',
    |        'alias' => 'Local storage',
    |    ]
    */
    'uploads-disk' => [
        'alias' => 'Uploads',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */
    
    'route' => [
        'prefix' => 'admin/elfinder',
        'middleware' => ['admin'], //Set to null to disable middleware filter
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */
    
    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
    
    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */
    
    'roots' => [
        [
            'driver' => 'LocalFileSystem',
            'path' => public_path('uploads'),
            'defaults' => [
                'read' => true,
                'write' => true,
                'locked' => false,
            ],
        ]
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => [
        'defaults' => [
            'read' => false,
            'write' => false
        ],
        'uploadOrder' => ['allow', 'deny']
    ],

);
