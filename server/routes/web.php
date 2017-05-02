<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

//TODO: For Admin routes, wrap it with auth middleware

$app->group(['prefix' => 'api'], function () use ($app) {
    // Cards
    $app->post('card/import', 'CardController@import');

    // Customer
    $app->post('customer', 'CustomerController@store');
    $app->post('customer/card', 'CustomerController@fetchCustomer');

    // Products
    $app->get('product/all', 'ProductController@index');
    $app->post('product', 'ProductController@store');
    $app->post('product/update', 'ProductController@update');
    $app->post('product/delete', 'ProductController@destroy');

    //Settings
    $app->post('settings', 'SettingController@store');
    $app->post('settings/fetch', 'SettingController@fetchSetting');

    // Rewards Setup
    $app->post('reward', 'RewardController@store');
    $app->get('reward/all', 'RewardController@all');

    // POS
    $app->post('purchase', 'POSController@store');
});