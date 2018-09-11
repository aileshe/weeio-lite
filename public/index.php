<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

# 网站统一入口文件  index.php

define('ROOT', realpath('../')); # 当前网站根目录路径  index.php 所在路径
define('CORE', ROOT . '/weeio');  # 框架核心目录
define('APP', ROOT . '/app');     # 项目文件目录


include CORE . '/weeio.php';
\weeio\weeio::run();