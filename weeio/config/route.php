<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

// Weeio 路由配置

return array(
    'PATHINFO' => true, # 默认启用 PATHINFO模式, 如果只想用普通?号传参模式 改 false

    'MODULE' => 'Home',      # 默认访问模块
    'CONTROLLER' => 'Index', # 默认控制器
    'ACTION' => 'index',     # 默认方法

    'OPEN_MODULE' => [       # 开放模块  按需要自行添加
        'Home' => true,
        'Api' => true,
        // ...
    ]
);