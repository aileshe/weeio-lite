<?php
/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

# Weeio 框架主体文件

namespace weeio;
class weeio{
    public static $classMap = []; # 载入类列表
    public static $_Di;           # DI实例对象

    protected $assign = NULL;        # 参数传值

    /**
     * 视图参数映射函数
     * @param  $name   参数名 或 数组
     * @param  $value  可选, 参数值
     */
    protected function assign($name, $value = NULL)
    {
        if(is_array($name)){
            $this->assign = $name;
        }else{
            $this->assign[$name] = $value;
        }
    }

    /**
     * 渲染view视图
     * @param  $file  可选, 视图文件路径(注意:视图文件必须放在View下对应控制器目录下)
     */
    protected function display($file = NULL)
    {
        $route = self::$_Di->get('\weeio\lib\Route');
        if($file){
            $view_file = APP.'/'.$route->_pathinfo['MODULE'].'/View/'.$route->_pathinfo['CONTROLLER'].'/'
                        .$file;
        }else{
            $view_file = APP.'/'.$route->_pathinfo['MODULE'].'/View/'.$route->_pathinfo['CONTROLLER'].'/'
                        .$route->_pathinfo['ACTION'].'.html';
        }
        if(is_file($view_file)){
            include $view_file;
        }
    }
    
    /**
     * 自动加载类方法 - 槽函数
     * @param  $class  类名
     * @return Bool
     */
    private static function load($class){
        $class = str_replace('\\','/',$class).'.php';
        if(!isset(self::$classMap[$class])){
            if(is_file(ROOT.'/'.$class)){
                include ROOT.'/'.$class;
                self::$classMap[$class] = $class;
            }else{
                return false;
            }
        }
        return true;
    }

    /**
     * weeio框架主体初始化函数
     * @return void
     */
    static public function run(){
        spl_autoload_register('self::load'); # 自动加载类

        # 载入共用函数库
        include CORE.'/func/Common.php';

        # 载入 PHP-IOC(DI-依赖注入)组件
        self::$_Di = \weeio\lib\DI::Di();

        # 初始化路由
        $route_conf = \weeio\lib\conf::all('/weeio/config/route');
        self::$_Di->set('\weeio\lib\Route',function()use($route_conf){
            return new \weeio\lib\Route($route_conf);
        });

        # 解析路由参数及调用相应模块、控制器和方法
        $route = self::$_Di->get('\weeio\lib\Route');
        $ctrlClass = '\app\\'.$route->_pathinfo['MODULE'].'\Controller\\'.$route->_pathinfo['CONTROLLER'];
        $action = $route->_pathinfo['ACTION'];
        $params = $route->_pathinfo['PARAMS'];
        self::ctl_bind_params($ctrlClass, $action, $params);
    }

    /**
     * 反射绑定参数调起类方法
     * @param  $ctrlClass  控制器类   xxx::class
     * @param  $action     访问的成员方法名
     * @param  $params  参数数组['id'=>28,'name'=>'Dejan']
     */
    public static function ctl_bind_params($ctrlClass, $action, $params)
    {
        # 获取类反射
        $controllerReflection = new \ReflectionClass($ctrlClass);
        # 判断该类是否可实例化对象
        if (!$controllerReflection->isInstantiable()) {
            throw new \RuntimeException("{$controllerReflection->getName()}控制器类不能被实例化!");
        }
        # 判断指定成员方法是否存在
        if (!$controllerReflection->hasMethod($action)) {
            throw new \RuntimeException("{$controllerReflection->getName()}找不到类方法:{$action}");
        }
        # 获取对应方法反射
        $actionReflection = $controllerReflection->getMethod($action);
        # 获取方法的参数的反射列表(多个参数反射组成的数组)
        $paramReflectionList = $actionReflection->getParameters();
        $_params = [];
        foreach ($paramReflectionList as $paramReflection) {
            # 同名参数赋予参数列表
            if (isset($params[$paramReflection->getName()])) {
                $_params[] = $params[$paramReflection->getName()];
                continue;
            }
            # 默认值直接赋予参数列表
            if ($paramReflection->isDefaultValueAvailable()) {
                $_params[] = $paramReflection->getDefaultValue();
                continue;
            }
            # 异常
            throw new \RuntimeException(
            "{$controllerReflection->getName()}::{$actionReflection->getName()}的参数{$paramReflection->getName()}必须传值"
            );
        }
        # 调起方法
        $actionReflection->invokeArgs($controllerReflection->newInstance(), $_params);
    }
}
