# Changelog

All Notable changes to `Backpack LangFileManager` will be documented in this file

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


## [1.0.8] - 2016-03-16

### Fixed
- Added page title.


## [1.0.7] - 2016-03-12

### Fixed
- LangFileManager can no longer use package lang files for backup, because that broke all other packages' backup lang files. Lang files for this package need to be published.

## [1.0.6] - 2016-03-12

### Fixed
- Lang files are pushed in the correct folder now. For realsies.
- Backpack\CRUD is now a composer requirement.


## [1.0.5] - 2016-03-12

### Fixed
- Change folder structure to resemble a Laravel app and other Backpack packages.
- Added the empty_file translation key in langfilemanager's language file.


## [1.0.4] - 2016-03-12

### Fixed
- Using a separate lang file from other Backpack packages, which can be published.


## [1.0.3] - 2016-03-12

### Fixed
- Renamed from Dick\TranslationManager to Backpack\TranslationManager.
- Now using separate config file.


## [1.0.2] - 2015-09-10

### Added
- Migrations and seeds for Laravel-Localizable integration.
- Extra methods on the Language model.

## [1.0.0] - 2015-09-07

### Added
- Base functionality (edit language files).
- Improved UX over the old interface.