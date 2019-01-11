<?php
/**
 * @link      https://github.com/duro85/ajaxauth
 *
 * @copyright 2017 Michelangelo Belfiore
 */
return [
    /*
      |--------------------------------------------------------------------------
      | AjaxAuth, Validators
      |--------------------------------------------------------------------------
      |
      | Config file  custom configuration/validation rules to register, login
      | and renew the user password for each guard.
      |
     */
    'validators' => [
        'foo' => [
            'register'    => [
                'firstname'   => 'required|max:255',
                'lastname'    => 'required|max:255',
                'email'       => 'required|email|max:255|unique:foo_table',
                'password'    => 'required|min:6',
            ],
            'login'       => [
                'email'     => 'required|email|max:255',
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
                'tax_code'    => 'required|max:255',
                'email'       => 'required|email|max:255|unique:bar_table',
                'password'    => 'required|min:6',
            ],
            'login'       => [
                'tax_code'  => 'required|min:255',
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
