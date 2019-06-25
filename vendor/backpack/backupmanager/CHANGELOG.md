# Changelog

All Notable changes to `backupmanager` will be documented in this file

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing


## [1.1.11] - 2016-09-24

### Fixed
- Routes now follow base prefix - thanks to [Twaambo Haamucenje](https://github.com/twoSeats);


## 1.1.10 - 2016-08-17

### Added
- Spanish translation, thanks to [Rafael Ernesto Ferro González](https://github.com/rafix);


## 1.1.9 - 2016-07-30

### Added
- Bogus unit tests. At least we'be able to use travis-ci for requirements errors, until full unit tests are done.


## 1.1.8 - 2016-07-25

### Fixed
- Download button with subfolders.


## 1.1.7 - 2016-07-13

### Added
- Showing files from multiple disks.
- Can delete files from other disks, other than local (tested Dropbox).

### Fixed
- Download link is no longer dependant on the suggested backups storage disk.
- Hidden download link if not using the Local filesystem.

### Removed
- Subfolder listing and downloading.

## 1.1.6 - 2016-06-03

### Fixed
- Download and delete buttons now work too, for subfolders.


## 1.1.5 - 2016-06-03

### Fixed
- Showing zip files from subfolders, too, since laravel-backup stores them that way.


## 1.1.4 - 2016-03-16

### Fixed
- Added page title.

## 1.1.3 - 2016-03-16

### Fixed
- Eliminated console logs from backup js.
- Added screenshot in README.

## 1.1.2 - 2016-03-16

### Fixed
- Made the backup button work.
- Added another error type - the warning when something failed.
- Logging the progress in the log files.
- Showing the artisan command output in the ajax response.
- Added the dump_command_path configuration.
- Changed README to instruct on common misconfiguration issue.


## 1.1.1 - 2016-03-15

### Fixed
- Correct name in readme. Confirming packagist hook.


## 1.1 - 2016-03-15

### Added
- Updated to v3 of spatie's laravel-backup package.
- Renamed everything to be part of Backpack instead of Dick.
