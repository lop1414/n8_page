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

// 后台公共权限接口
$router->group([
    // 路由中间件
    'middleware' => ['center_login_auth', 'access_control_allow_origin'],
    // 前缀
    'prefix' => 'admin'
], function () use ($router) {
    // 文件
    $router->group(['prefix' => 'file', 'middleware' => ['admin_request_log']], function () use ($router) {
        $router->post('upload', 'Admin\FileController@upload');
        $router->post('read', 'Admin\FileController@read');
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
        $router->post('push_give', 'Admin\AdPageController@pushGive');
    });
});
