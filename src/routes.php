<?php


Route::group(['middleware' => 'web'], function() {
    // send email with reset link
    Route::any('/ajaxauth/password/sendresetemail/{guard}', "Duro85\AjaxAuth\AjaxAuthController@passwordSendResetEmail")->where(['guard' => '[\w\-\d]+']);
    // save new password
    Route::any('/ajaxauth/password/new/{guard}', "Duro85\AjaxAuth\AjaxAuthController@passwordNew")->where(['guard' => '[\w\-\d]+']);
    // register new user
    Route::any('/ajaxauth/register/{guard}', "Duro85\AjaxAuth\AjaxAuthController@register")->where(['guard' => '[\w\-\d]+']);
    // authenticate user
    
    Route::any('/ajaxauth/login/{guard}', "Duro85\AjaxAuth\AjaxAuthController@login")->where(['guard' => '[\w\-\d]+']);    
    // logout current logged user
    
    Route::any('/ajaxauth/logout/{guard}', "Duro85\AjaxAuth\AjaxAuthController@logout")->where(['guard' => '[\w\-\d]+']);    
});