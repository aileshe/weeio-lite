<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

# Weeio-lite 路由解析类

namespace weeio\lib;

class Route
{
    public $_pathinfo = array(
        'PATHINFO' => true, # 默认启用 PATHINFO模式, 如果只想用普通?号传参模式 改 false

        'URI_DELIMIT' => '/',    # url参数分隔符一般是'/' 或 '-' , 如: /Index/index/id/28  或 /Index-index-id-28

        'MODULE' => 'Home',      # 默认访问模块
        'CONTROLLER' => 'Index', # 默认控制器
        'ACTION' => 'index',     # 默认方法

        'OPEN_MODULE' => [],     # 开放模块  按需要自行添加

        'PARAMS' => [],          # 参数
    );

    public function __construct($config = null)
    {
        # 载入配置
        if ($config !== null) {
            foreach ($config as $item => $val) {
                $this->_pathinfo[$item] = $val;
            }
        }

        # 路由美化处理
        // xxx.com/index.php/Home/Index/index
        // xxx.com/Home/Index/index
        // xxx.com/index.php/Index/index
        // xxx.com/Index/index
        $_get = $_GET;
        # 混合控制  $_GET['pathinfo'] == 'off' 切换为 解析类型2
        if (@$_get['pathinfo'] == 'off') {
            $this->_pathinfo['PATHINFO'] = false;
        }

        if ($this->_pathinfo['PATHINFO']) {
            # 解析类型1: PATHINFO 模式 示例: xxx.com/index/index/id/28
            $request_uri_array = explode($this->_pathinfo['URI_DELIMIT'], trim($_SERVER['REQUEST_URI'], '/'));
            if (!empty($request_uri_array) && !empty($request_uri_array[0])) {
                $request_uri_array[0] = ucfirst($request_uri_array[0]); # 访问模块名 和 控制器名 首字母必须是大写的, 所有这里自动转换
                if (isset($this->_pathinfo['OPEN_MODULE'][$request_uri_array[0]])) {
                    # 1) xxx.com/Home/Index/index
                    $this->_pathinfo['MODULE'] = $request_uri_array[0]; # 设置当前访问模块
                    $param_num = count($request_uri_array);
                    for ($i = 1; $i < $param_num; $i++) {
                        if ($i === 1) { # 控制器 controller
                            $this->_pathinfo['CONTROLLER'] = ucfirst($request_uri_array[$i]);
                        } else if ($i === 2) { # 方法 action
                            $this->_pathinfo['ACTION'] = $request_uri_array[$i];
                        } else { # 参数 param
                            $this->_pathinfo['PARAMS'][$request_uri_array[$i]] = @$request_uri_array[++$i];
                        }
                    }
                } else {
                    # 2) xxx.com/Index/index
                    $this->_pathinfo['CONTROLLER'] = $request_uri_array[0]; # 设置当前控制器
                    $param_num = count($request_uri_array);
                    for ($i = 1; $i < $param_num; $i++) {
                        if ($i === 1) { # 方法 action
                            $this->_pathinfo['ACTION'] = $request_uri_array[$i];
                        } else { # 参数 param
                            $this->_pathinfo['PARAMS'][$request_uri_array[$i]] = @$request_uri_array[++$i];
                        }
                    }
                }
            }
            $_GET = $this->_pathinfo['PARAMS']; # 赋予GET参数
            $this->_pathinfo['PARAMS'] = array_merge($this->_pathinfo['PARAMS'], $_POST);
        } else if (!empty($_get)) {
            # 解析类型2: URL普通 '?' 号传参解析处理

            if (!empty($_get['m'])) {
                $this->_pathinfo['MODULE'] = ucfirst($_get['m']);
            }
            if (!empty($_get['c'])) {
                $this->_pathinfo['CONTROLLER'] = ucfirst($_get['c']);
            }
            if (!empty($_get['a'])) {
                $this->_pathinfo['ACTION'] = $_get['a'];
            }
            $this->_pathinfo['PARAMS'] = array_merge($_GET, $_POST);
        }
    }
}