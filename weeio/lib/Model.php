<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

# 模型类

namespace weeio\lib;

class Model
{
    protected static $_db;

    public function __construct()
    {
        $di = \weeio\weeio::$_Di;
        $db_conf = \weeio\lib\Conf::all('/weeio/config/database');
        $di::set('\weeio\lib\Medoo', function () use ($db_conf) {
            return new \weeio\lib\Medoo($db_conf);
        });
        self::$_db = $di::get('\weeio\lib\Medoo');
    }
}