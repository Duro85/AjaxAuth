# AjaxAuth (Laravel >=5.3 Package)
[![StyleCI](https://styleci.io/repos/73827252/shield?branch=master)](https://styleci.io/repos/73827252)

AjaxAuth it's a simple package that provides a fully configurable authorization/registration flow via ajax. It provides its controllers and publishes its configuration and its routes, which can then be changed at will.

## Contents

- [Installation](#installation)
- [License](#license)
- [Contribution guidelines](#contribution-guidelines)

## Installation

1) In order to install AjaxAuth, just add the following to your composer.json. Then run `composer update`:

```json
"Duro85/AjaxAuth": "0.*"
```

2) Open your `config/app.php` and add the following to the `providers` array:

```php
Duro85\AjaxAuth\AjaxAuthServiceProvider::class,
Duro85\AjaxAuth\AjaxAuthRouteServiceProvider::class,
```

3) execute command : 
```
php artisan vendor:publish
```
this will publish routes, configurations and language files.

4) edit your model : in order to get a fully configurable Notification for the retrieve password email
you have to insert this code into each Authenticatable model : 

```
    public function sendPasswordResetNotification($token)
    {        
        $this->notify(new AjaxAuthNotification($token, 'guard_name', ['name' => $this->name]));
    }
```
this method overrides the standard one and lets you manage EASILY your email notification. 
AjaxAuthNotification acepts three params : a $tocken (don't bother at it, it'll be provided by the framework ), 
a guard name ( to retrieve the right configuration ), and an optional array of params to be passed to an email view to personalize the message (cool huh ?).
How this works ? Really simply, let's have a look to the code : 
```
public function toMail($notifiable)
    {
        // get password config 
        $config = config("auth.passwords.{$this->guard}");
        if (isset($config['view'])) {
            /*
             * custom view message
             */
            return (new MailMessage)->view($config['view'], $this->mail_params);
        } else {
            /**
             * standard laravel notification email with localizable test            
             */
            //you can specify a different route for each guard
            $link = isset($config['route']) ? route($config['route'], $this->token) : route('password.reset', $this->token);            
            return (new MailMessage)->view()
                            ->line('You are receiving this email because we received a password reset request for your account.')
                            ->action('Reset Password', $link)
                            ->line('If you did not request a password reset, no further action is required.');
        }
    }
```
As you can see, the behaviour of this custom Notification it's influenced by the password config. array, to be more precise
you can choose to set, in the config array, a 'view' key to specify a full custom email template or a 'route' key to use the standard email notification template but with a specific ( for the guard ) link, so you no longer have to have a single link to the password reset form, each guard will have its link !
Let me give you a couple of example : 
```
// file : config/auth.php
'passwords' => [
    'foo' => [
        'provider' => 'provider_foo',
        'view'    => 'auth.emails.passwords_foo',
        'table'    => 'password_resets_foo',
        'expire'   => 240,
    ],
    'bar' => [
        'provider' => 'provider_bar',
        'route'    => 'bar.reset.password',
        'table'    => 'password_resets_bar',
        'expire'   => 240,
    ],
],
```
5) configure your validators : this package will publish a ajaxauth.php into your config/ folder, this configuration file will store your guard' validators, let's have  : 
```
return [
    'validators' => [
        'foo' => [
            'register'    => [
                'firstname'   => 'required|max:255',
                'lastname'   => 'required|max:255',
                'email'       => 'required|email|max:255|unique:foo_table',
                'password'    => 'required|min:6',
            ],
            'login'       => [
                'email' => 'required|email|max:255',
                'password'  => 'required|min:6|confirmed',
            ],
            'passwordnew' => [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|confirmed|min:6',
            ],
        ],
        'bar' => [
            'register'    => [
                'tax_code'   => 'required|max:255',
                'email'       => 'required|email|max:255|unique:bar_table',
                'password'    => 'required|min:6',
            ],
            'login'       => [
                'tax_code' => 'required|min:255',
                'password'  => 'required|min:6|confirmed',
            ],
            'passwordnew' => [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|confirmed|min:6',
            ],
        ],
    ],
];
```
6) that's it ! Of course you still need to build forms and controllers to display them, but now you can let them work in AJAX !! ( such form, very ajax, much laravel ! ) 

## License

AjaxAuth is free software distributed under the terms of the BSD-3-Clause license. Please refer to [license](LICENSE). 

## Contribution guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.  
Pull requests are welcome.