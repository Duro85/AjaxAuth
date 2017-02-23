# AjaxAuth (Laravel >=5.3 Package)

AjaxAuth it's a simple package that provides a fully configurable authorization/registration flow via ajax. It provides its controllers and publishes its configuration and its routes, which can then be changed at will.

## Contents

- [Installation](#installation)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)

## Installation

1) In order to install AjaxAuth, just add the following to your composer.json. Then run `composer update`:

```json
"Duro85/AjaxAuth": "1.*"
```

2) Open your `config/app.php` and add the following to the `providers` array:

```php
Duro85\AjaxAuth\AjaxAuthServiceProvider::class,
Duro85\AjaxAuth\AjaxAuthRouteServiceProvider::class,
```

## License

AjaxAuth is free software distributed under the terms of the BSD-3-Clause license. Please refer to [license](LICENSE). 

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.  
Pull requests are welcome.