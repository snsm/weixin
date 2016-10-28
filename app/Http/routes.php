<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('wechat', 'WechatController@serve');

Route::any('user', 'WechatController@user');

Route::any('oauth_callback', 'WechatController@oauth_callback');

Route::any('login', 'WechatController@login');