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
//执行登录获取token
$router->get('api/v1/login', ['uses' => 'Api\UserController@login']);
$router->group(['namespace' => 'Api'
    , 'prefix' => 'api/v1'], function($router) {
    // 'middleware' => 'auth'
    //测试路由
    $router->get('test', 'TestController@test');
    $router->get('refresh-token', 'UserController@refreshToken');
    $router->get('logout', 'UserController@logout');
});

/**
 * 微信接口定义
 */
$router->group(['namespace' => 'Wechat'
    , 'prefix' => 'mini'], function($router) {
    // 'middleware' => 'auth'
    //测试路由
    $router->post('serve', 'TestController@serve');
});

