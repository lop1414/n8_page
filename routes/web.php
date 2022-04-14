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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 公开接口
$router->group([
    'prefix' => 'open',
    'middleware' => ['access_control_allow_origin']
], function () use ($router) {

    $router->group(['prefix' => 'page_show'], function () use ($router) {
        $router->get('ad_page', 'Open\PageShowController@adPage');// 推广页面pv
    });
});

// 后台
$router->group([
    'prefix' => 'admin',
    'middleware' => ['center_menu_auth', 'admin_request_log', 'access_control_allow_origin']
], function () use ($router) {
    // 广告落地页
    $router->group(['prefix' => 'ad_page'], function () use ($router) {

        $router->post('select', 'Admin\AdPageController@select');
        $router->post('get', 'Admin\AdPageController@get');
        $router->post('read', 'Admin\AdPageController@read');
        $router->post('enable', 'Admin\AdPageController@enable');
        $router->post('disable', 'Admin\AdPageController@disable');
        $router->post('create', 'Admin\AdPageController@create');
        $router->post('update', 'Admin\AdPageController@update');
    });
});
