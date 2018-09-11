<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

namespace app\Api\Controller;

class Index
{
    public function __construct()
    {
        # 查看当前路由信息
        //print_r(\weeio\weeio::$_Di->get('\weeio\lib\Route'));
    }

    # PATHINFO模式访问 URL: http://127.0.0.1/api/ 或 http://127.0.0.1/api/index 
    # 普通模式访问 URL: http://127.0.0.1/?m=api 或 http://127.0.0.1/?m=api&c=index
    public function index()
    {
        # 使用自定义Model
        $model = new \app\Api\Model\User();
        echo json_encode($model->get_all());
    }

    # PATHINFO模式访问 URL: http://127.0.0.1/api/index/test
    # 普通模式访问 URL: http://127.0.0.1/?m=api&c=index&a=test
    public function test()
    {
        # weeio框架集成于Medoo数据操作引擎, 详细使用文档请查阅 https://medoo.in/doc
        # Medoo 很优雅! 爱上她你将无法自拔。

        # 数据库配置文件路径: /weeio/config/database.php
        # 数据库操作示例导入数据文件(数据库脚本文件)路径: /extend/weeio-lite.sql

        # 通过 M()函数直接获得数据操作实例对象
        $data = M()->select(
            'user', # 数据库表名
            '*'    # 查询字段
        );
        echo json_encode($data);
    }

}