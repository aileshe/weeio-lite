<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio 公共函数库

/**
 * config 配置读取函数
 * @param  $key             配置项key 或  配置文件名
 * @param  $file[optional]  配置文件名
 */
function C($key, $file = null)
{
    if ($file) {
        return \weeio\lib\Conf::get($key, $file); # 单个配置读取
    } else {
        return \weeio\lib\Conf::all($key); # 整个配置文件读取
    }
}

/**
 * 获取数据库操作实例句柄函数
 * @param   $dbname  可选, 数据库名(一般不推荐传值)
 * @return  Object
 */
function M($dbname = null)
{
    if ($dbname) {
        $di = \weeio\weeio::$_Di;
        $db_conf = \weeio\lib\Conf::all('/weeio/config/database');
        $db_conf['database_name'] = $dbname; # 切换数据库
        $di::_set('\weeio\lib\Medoo', function () use ($db_conf) {
            return new \weeio\lib\Medoo($db_conf);
        });
        return $di::_get('\weeio\lib\Medoo');
    }
    $di = \weeio\weeio::$_Di;
    $db_conf = \weeio\lib\Conf::all('/weeio/config/database');
    $di::set('\weeio\lib\Medoo', function () use ($db_conf) {
        return new \weeio\lib\Medoo($db_conf);
    });
    return $di::get('\weeio\lib\Medoo');
}
