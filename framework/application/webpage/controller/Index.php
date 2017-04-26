<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use sys\Cookie;

class Index
{

    public function index()
    {
        echo "Route::rule('/*$', 'webpage/controller/Index/index');";
        Cookie::set('name', 'xiaohua', 7200);
        Cookie::set('sex', 'w', 7200);
        var_dump(Cookie::get());
        // Cookie::delete('name');
        // Cookie::clear();
    }

}
