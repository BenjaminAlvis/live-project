<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // 引用在 PHP 文件中要使用的类

class StaticPagesController extends Controller
{
    // 现在的静态页面控制器中还没有指定好三个页面对应的动作，让我们来为控制器加上这三个动作来处理从路由发过来的请求：
    public function home()
    {
        // return '主页'; // 这种返回的只是文字，而不是视图
        // 要在控制器中指定渲染某个视图，则需要使用到 view 方法，
        // view 方法接收两个参数，第一个参数是视图的路径名称，第二个参数是与视图绑定的数据，第二个参数为可选参数。
        // 下面这行代码，将会渲染在 resources/views 文件夹下的 static_pages/home.blade.php 文件
        return view('static_pages/home');
    }
    public function help()
    {
        return view('static_pages/help');
    }
    public function about()
    {
        return view('static_pages/about');
    }
}
