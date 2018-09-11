<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

namespace app\Api\Model;

class User extends \weeio\lib\Model
{
    /**
     * 获取所有用户
     */
    public function get_all()
    {
        //var_dump(self::$_db); # 打印数据库操作实例对象

        # weeio框架集成于Medoo数据操作引擎, 详细使用文档请查阅 https://medoo.in/doc
        # Medoo 很优雅! 爱上她你将无法自拔。

        # 数据库配置文件路径: /weeio/config/database.php
        # 数据库操作示例导入数据文件(数据库脚本文件)路径: /extend/weeio-lite.sql

        return self::$_db->select(
            'user', # 数据库表名
            '*'     # 查询字段
        );
    }
}