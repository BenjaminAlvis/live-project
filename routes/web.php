<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get 表明这个路由将会响应 GET 请求
Route::get('/', function () { // 第一个参数指明URL，第二个参数指明了处理该 URL 的控制器动作。
    return view('welcome');
});
// 这个代码就是说，我们向 http://sample.test/ 发出了一个get请求，则该请求将会返回一个叫做welcome视图

Route::get('/','StaticPagesController@home');
Route::get('/help','StaticPagesController@help');
Route::get('/about','StaticPagesController@about');