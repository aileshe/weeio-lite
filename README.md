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

## 4.控制器
## 5.模型
## 6.视图
