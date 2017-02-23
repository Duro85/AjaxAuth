<?php
Route::group(['middleware' => 'web'], function() {
    Route::any('/ajaxauth/password/sendresetemail/{guard}', "Duro85\AjaxAuth\AjaxAuthController@passwordSendResetEmail")->where(['guard' => '[\w\-\d]+']);
    Route::any('/ajaxauth/password/new/{guard}', "Duro85\AjaxAuth\AjaxAuthController@passwordNew")->where(['guard' => '[\w\-\d]+']);

    Route::any('/ajaxauth/register/{guard}', "Duro85\AjaxAuth\AjaxAuthController@register")->where(['guard' => '[\w\-\d]+']);
    Route::any('/ajaxauth/login/{guard}', "Duro85\AjaxAuth\AjaxAuthController@login")->where(['guard' => '[\w\-\d]+']);
    Route::any('/ajaxauth/logout/{guard}', "Duro85\AjaxAuth\AjaxAuthController@logout")->where(['guard' => '[\w\-\d]+']);    
});



