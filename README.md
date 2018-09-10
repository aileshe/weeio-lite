# weeio-lite 是什么?
Weeio-lite  简单、高效，一个超轻量级的PHP-MVC框架！

## 1.目录结构
```
Weeio-lite
├─app  # 应用目录
│  ├─Api  # 模块1
│  │  ├─Controller  # 控制器目录
│  │  │      Index.php  # 控制器类文件
│  │  └─Model  # 模型目录
│  │          User.php  # 模型类文件
│  └─Home  # 模块2
│      ├─Controller  # 控制器目录
│      │      Index.php  # 控制器类文件
│      ├─Model  # 模型类目录
│      └─View   # 视图目录
│          └─Index  # 控制器Index视图目录
│                  index.html  # 视图文件(后缀是.html 或 .php)
│                  test.html
│                  test2.html
├─extend  # 框架扩展类目录
│      weeio-lite.sql  # Weeio-lite示例数据, 可删除
├─public  # 网站根目录
│      .htaccess  # Apache脚本文件, 默认配置URL路由美化
│      index.php  # 网站入口文件
└─weeio  # weeio-lite 框架核心目录
    │  weeio.php  # 框架核心引导文件
    ├─config  # 框架配置文件目录
    │      database.php  # 数据库配置文件
    │      route.php     # 路由配置
    ├─func  # 全局函数库
    │      Common.php  # 公用函数库文件
    └─lib   # weeio-lite 核心类库
            Conf.php   # 配置读取载入类
            DI.php     # PHP-IOC(DI-依赖注入)类
            Medoo.php  # 数据库操作引擎类
            Model.php  # 模型控制类
            Route.php  # 路由解析类

```
## 2.文件命名规范
> 模块目录(Module)、控制器目录(Controller)、模型目录(Model)、视图目录(View)、视图下的控制器目录(View/..)、控制器类文件、模型类文件 命名首字母必须是大写的, 如下结构
```
├─app  # 应用目录
│  ├─Api  # 模块1
│  │  ├─Controller  # 控制器目录
│  │  │      Index.php  # 控制器类文件
│  │  └─Model  # 模型目录
│  │          User.php  # 模型类文件
│  └─Home  # 模块2
│      ├─Controller  # 控制器目录
│      │      Index.php  # 控制器类文件
│      ├─Model  # 模型类目录
│      └─View   # 视图目录
│          └─Index  # 控制器Index视图目录
│                  index.html  # 视图文件(后缀是.html 或 .php)
│                  test.html
│                  test2.html
```
## 3.路由
> weeio-lite路由解析模式仅有两种: PATHINFO模式、普通模式 <br/>默认启用: PATHINFO模式
#### 3.1 路由配置
> 路由配置文件所在路径:  /weeio/config/route.php
```
<?php

return array(
    'PATHINFO' => true, # 默认启用 PATHINFO模式, 如果只想用普通?号传参模式 改 false

    'MODULE' => 'Home',      # 默认访问模块
    'CONTROLLER' => 'Index', # 默认控制器
    'ACTION' => 'index',     # 默认方法

    'OPEN_MODULE' => [       # 开放模块  (注意: 新增的模块必须把模块名添加到该数组中)
        'Home' => true,      # '模块名' => true
        'Api' => true,
        // ...
    ]
);
```
#### 3.2 PATHINFO模式下url访问格式
> (1) 如何通过URL访问模块下的控制器方法
```
# 示例: 访问Home模块下Index控制器index方法

http://127.0.0.1/home/index/index
                   |    |     └───── 方法名Action (首字母必须是小写)
                   |    └───── 控制器名Controller (首字母可大小写)
                   └───── 模块名Module (首字母可大小写)
        等同于↓  
http://127.0.0.1/Home/Index/index
                   |    |     └───── 方法名Action (首字母必须是小写)
                   |    └───── 控制器名Controller (首字母可大小写)
                   └───── 模块名Module (首字母可大小写)
        等同于↓ 
http://127.0.0.1/index/index
                   |    └───── 方法名Action (首字母必须是小写), 没有指定"模块名"会自动调用配置文件中定义的默认模块
                   └───── 控制器名Controller (首字母可大小写)
        等同于↓
http://127.0.0.1/Index/index
                   |    └───── 方法名Action (首字母必须是小写), 没有指定"模块名"会自动调用配置文件中定义的默认模块
                   └───── 控制器名Controller (首字母可大小写)
        等同于↓ 
http://127.0.0.1/home/index
                  |    └───── 控制器名Controller (首字母可大小写), 没有指定"方法名Action"会自动调用路由配置文件中定义的默认方法
                  └───── 模块名Module (首字母可大小写)
        等同于↓   
http://127.0.0.1/Home/Index
                  |    └───── 控制器名Controller (首字母可大小写), 没有指定"方法名Action"会自动调用路由配置文件中定义的默认方法
                  └───── 模块名Module (首字母可大小写)
        等同于↓ 
http://127.0.0.1/index
                   └───── 控制器名Controller (首字母可大小写), 没有指定"模块名Module、方法名Action名"会自动调用路由配置文件中定义默认的
        等同于↓   
http://127.0.0.1/Index
                   └───── 控制器名Controller (首字母可大小写), 没有指定"模块名Module、方法名Action名"会自动调用路由配置文件中定义默认的
        等同于↓
http://127.0.0.1/Home
                   └───── 模块名Module (首字母可大小写), 没有指定"控制器名Controller"会自动调用路由配置文件中定义的默认控制器, 没指定方法同理
        等同于↓
http://127.0.0.1/home
                   └───── 模块名Module (首字母可大小写), 没有指定"控制器名Controller"会自动调用路由配置文件中定义的默认控制器, 没指定方法同理
        等同于↓
http://127.0.0.1/
          └───── 模块名Module、控制器名Controller、方法名Action 都不填也可以, 都会自动调用配置定义默认的
```
> (2) 如何通过URL传递参数
```
# 示例: 传递参数 id=28, name=dejan  给  Home模块下Index控制器的index方法

http://127.0.0.1/home/index/index/id/28/name/dejan
                   |    |     └───── 方法名Action (首字母必须是小写)
                   |    └───── 控制器名Controller (首字母可大小写)
                   └───── 模块名Module (首字母可大小写)
        等同于↓ 
http://127.0.0.1/index/index/id/28/name/dejan
                   |    └───── 方法名Action (首字母必须是小写)
                   └───── 控制器名Controller (首字母可大小写)
```
> (3) 如何在PATHINFO模式下强制使用普通"?"号传参模式
```
# 示例: 以下链接是一个API接口, 出于安全和性能考虑并不需要在PATHINFO模式下解析, 通常都会以POST方式提交参数数据那么必须强制关闭PATHINFO方式解析, 这样效率会更高、速度更快！

http://127.0.0.1/?pathinfo=off&m=home&c=index&a=index
           等同于↓
http://127.0.0.1/?m=home&c=index&a=index&pathinfo=off
```
#### 3.3 普通模式下url访问格式
```
```
## 4.控制器
## 5.模型
## 6.视图
## 7.IOC容器(DI-依赖注入)
## 8.weeio-lite 框架核心
## 9.框架扩展
## 10.集成Composer
