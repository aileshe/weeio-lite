<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

namespace app\Home\Controller;

class Index extends \weeio\weeio
{
    # PATHINFO模式访问 URL: http://127.0.0.1/ 或 http://127.0.0.1/home/ 或 http://127.0.0.1/index 
    # 普通模式访问 URL: http://127.0.0.1/ 或 http://127.0.0.1/?m=home 或 http://127.0.0.1/?c=index
    public function index()
    {
        $route_conf = \weeio\lib\conf::all('/weeio/config/route'); # weeio 路由配置读取
        print_r(\weeio\weeio::$classMap); # weeio框架底层所有 include 文件列表
        print_r(\weeio\weeio::$_Di->get('\weeio\lib\Route')); # weeio底层使用了IOC(ID-依赖注入)在任意地方都可以查看容器实例列表

    }

    # PATHINFO模式访问 URL: http://127.0.0.1/index/test/name/dejan/id/28 或 http://127.0.0.1/home/index/test/name/dejan/id/28
    # 普通模式访问 URL: http://127.0.0.1/?c=index&a=test&name=dejan&id=28 或 http://127.0.0.1/?m=home&c=index&a=test&name=dejan&id=28
    public function test($id, $name)
    {
        # 调用 assign()、display() 方法, 控制器必须继承 weeio 框架核心类
        # 如果当前控制器是应用接口回调接口不会用到View视图, 不用继承weeio 框架核心类也可以访问 action方法
        $this->assign('name', $name); # 单个变量映射
        $this->assign('id', $id);

        $data = [
            'id' => $id,
            'name' => $name
        ];
        $this->assign($data); # 多个变量映射, 数组

        $this->display(); # 视图渲染weeio默认会找到控制器方法相应view文件(注意:视图文件必须放在View下对应控制器目录下)
        //$this->display('test2.html'); # 当然也可以指定视图文件 , 但必须放在模块下View对应的控制器目录下
    }
}