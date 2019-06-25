# Backpack\BackupManager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/backpack/backupmanager.svg?style=flat-square)](https://packagist.org/packages/backpack/backupmanager)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-backpack/backupmanager/master.svg?style=flat-square)](https://travis-ci.org/laravel-backpack/backupmanager)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/backupmanager.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-backpack/backupmanager/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-backpack/backupmanager.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-backpack/backupmanager)
[![Style CI](https://styleci.io/repos/53956594/shield)](https://styleci.io/repos/53956594)
[![Total Downloads](https://img.shields.io/packagist/dt/backpack/backupmanager.svg?style=flat-square)](https://packagist.org/packages/backpack/backupmanager)

An admin interface for managing backups (download and delete). Used in the Backpack package, on Laravel 5.2+

**Subscribe to the [Mailchimp list](http://eepurl.com/bUEGjf) to be up to date with the community.**

![Backpack\BackupManager screenshot](https://infinit.io/_/cU2PtmD.png)


## Install

1) In your terminal

``` bash
$ composer require backpack/backupmanager
```

2) Then add the service providers to your config/app.php file:

```
'Spatie\Backup\BackupServiceProvider',
'Backpack\BackupManager\BackupManagerServiceProvider',
```

3) Publish the config file and lang files:

```
php artisan vendor:publish --provider="Backpack\BackupManager\BackupManagerServiceProvider"
```

4) Add a new "disk" to config/filesystems.php:

```php
        // used for Backpack/BackupManager
        'backups' => [
            'driver' => 'local',
            'root'   => storage_path('backups'), // that's where your backups are stored by default: storage/backups
        ],
```
This is where you choose a different driver if you want your backups to be stored somewhere else (S3, Dropbox, Google Drive, Box, etc).

5) [optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>
```

6) [optional] Modify your backup options in config/laravel-backup.php

7) [optional] Instruct Laravel to run the backups automatically in your console kernel:

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
   $schedule->command('backup:clean')->daily()->at('04:00');
   $schedule->command('backup:run')->daily()->at('05:00');
}
```

8) Check that it works

If the "unknown error" yellow bubble is thrown and you see the "_Backup failed because The dump process failed with exitcode 127 : Command not found._" error in the log file, either mysqldump / pg_dump is not installed or you need to specify its location.

You can do that in your config/database.php file, where you define your database credentials, by adding the _dump_command_path_ variable. Example for Mac OS X's MAMP:

```php
'mysql' => [
            'driver'            => 'mysql',
            'host'              => env('DB_HOST', 'localhost'),
            'database'          => env('DB_DATABASE', 'forge'),
            'username'          => env('DB_USERNAME', 'forge'),
            'password'          => env('DB_PASSWORD', ''),
            'charset'           => 'utf8',
            'collation'         => 'utf8_unicode_ci',
            'prefix'            => '',
            'strict'            => false,
            'engine'            => null,
            'dump_command_path' => '/Applications/MAMP/Library/bin/', // only the path, so without 'mysqldump' or 'pg_dump'
            'dump_command_timeout' => 60 * 5, // 5 minute timeout
            'dump_using_single_transaction' => true, // perform dump using a single transaction
        ],
```

## Usage

Point and click, baby. Point and click.

Try at **your-project-domain/admin/backup**


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

## Credits

- [Cristian Tabacitu](https://github.com/tabacitu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
