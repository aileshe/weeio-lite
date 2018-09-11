<?php

/**
 * weeio-lite - 简单、高效，一个超轻量级的PHP-MVC框架    http://github.com/aileshe/weeio
 * Copyright (c) 2018 Dejan.He All rights reserved.
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * Author: Dejan.He <673008865@qq.com>
 */

 # 轻量级IOC (DI-依赖注入)

namespace weeio\lib;

# Di依赖注入标准接口
interface DiAwareInterface
{
    public function setDI(DI $di);
    public function getDI();
}

class DI
{
    private static $_container = []; # 非共享实例对象, 每次调用重新构建
    private static $_sharedContainer = []; # 共享实例
    private static $_Di = null; # $this

    private function __construct()
    {
    } # 防止类构造函数初始化
    private function __clone()
    {
    }     # 防止克隆函数调用

    /**
     * DI容器初始化函数
     * @return $this
     */
    public static function Di()
    {
        if (self::$_Di === null) {
            self::$_Di = new DI();
        }
        return self::$_Di;
    }

    /**
     * 添加一个实例对象到容器 - 已存在实例不进行构建
     * @param  $name        键名(对象名)
     * @param  $instance    实例对象(classObject)
     * @param  Bool         返回true 成功
     */
    public static function set($name, $instance)
    {
        # 已存在实例不进行构建
        if (is_object(($instance = call_user_func($instance))) && !isset(self::$_sharedContainer[$name])) {
            self::$_sharedContainer[$name] = $instance;
            # 定义 DiAwareInterface 接口，自动注入 Di
            if ($instance instanceof \DiAwareInterface) {
                $instance->setDI(self::$_Di);
            }
            return true;
        }
        return false;
    }

    /**
     * 添加一个实例对象到容器 - 非共享实例, 每次调用重新构建
     * @param  $name        键名(对象名)
     * @param  $instance    实例对象(classObject)
     * @param  Bool         返回true 成功
     */
    public static function _set($name, $instance)
    {
        # 非共享实例, 每次调用重新构建
        if (is_object(($instance = call_user_func($instance))) && !isset(self::$_container[$name])) {
            self::$_container[$name] = $instance;
            # 定义 DiAwareInterface 接口，自动注入 Di
            if ($instance instanceof \DiAwareInterface) {
                $instance->setDI(self::$_Di);
            }
            return true;
        }
        return false;
    }

    /**
     * 获取DI容器里指定的实例对象 - 共享实例容器
     * @param  $name  键名(对象名)
     * @return InstanceObject
     */
    public static function get($name)
    {
        if (isset(self::$_sharedContainer[$name])) {
            $instance = self::$_sharedContainer[$name];
        } else {
            throw new Exception("Instance '{$name}' wasn't found in the dependency injection container");
        }
        return $instance;
    }

    /**
     * 获取DI容器里指定的实例对象 - 非共享实例容器
     * @param  $name  键名(对象名)
     * @return InstanceObject
     */
    public static function _get($name)
    {
        if (isset(self::$_container[$name])) {
            $instance = self::$_container[$name];
        } else {
            throw new Exception("Instance '{$name}' wasn't found in the dependency injection container");
        }
        return $instance;
    }

    /**
     * 判断实例对象是否在Di容器里 - 共享实例容器
     * @param  $name  键名(对象名)
     * @return Bool
     */
    public static function has($name)
    {
        return isset(self::$_sharedContainer[$name]);
    }

    /**
     * 判断实例对象是否在Di容器里 - 非共享实例容器
     * @param  $name  键名(对象名)
     * @return Bool
     */
    public static function _has($name)
    {
        return isset(self::$_container[$name]);
    }

    /**
     * 从Di容器中删除指定实例 - 共享实例容器
     * @param  $name  键名(对象名)
     * @param  void
     */
    public static function del($name)
    {
        unset(self::$_sharedContainer[$name]);
    }

    /**
     * 从Di容器中删除指定实例 - 非共享实例容器
     * @param  $name  键名(对象名)
     * @param  void
     */
    public static function _del($name)
    {
        unset(self::$_container[$name]);
    }
}