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
      | You use this file as a blueprint to crate a config file and add there the
      | custom configuration/validation rules to register, login and renew the
      | user password for each guard.
      |
      | New files will be named like : ajaxauth_{guard}.php
     */
    'validators' => [
        'register'    => [
            'firstname'   => 'required|max:255',
            'email'       => 'required|email|max:255|unique:users',
            'password'    => 'required|min:6',
            'type_name'   => 'required',
            'status_name' => 'required',
        ],
        'login'       => [
            'firstname' => 'required|min:3',
            'password'  => 'required|min:6|confirmed',
        ],
        'passwordnew' => [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ],
    ],
];
