# weeio-lite 是什么?
Weeio-lite  简单、高效，一个超轻量级的PHP-MVC框架！

## 1. 目录结构
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
## 2. 文件命名规范
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
## 3. 路由 Route
> weeio-lite路由解析模式仅有两种: PATHINFO模式、普通模式 <br/>默认启用: PATHINFO模式
#### 3.1 路由文件配置
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
#### 3.2 PATHINFO模式下的URL格式
> (1) 如何通过URL访问模块下的控制器方法?
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
                   |    └───── 方法名Action (首字母必须是小写), 没有指定"模块名Module"会自动调用配置文件中定义的默认模块
                   └───── 控制器名Controller (首字母可大小写)
        等同于↓
http://127.0.0.1/Index/index
                   |    └───── 方法名Action (首字母必须是小写), 没有指定"模块名Module"会自动调用配置文件中定义的默认模块
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
> (2) 如何通过URL传递参数?
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
> (3) 如何在PATHINFO模式下强制使用普通"?"号传参模式?
```
# 示例: 以下链接是一个API接口, 出于安全和性能考虑并不需要在PATHINFO模式下解析, 通常都会以POST方式提交参数数据那么必须强制关闭PATHINFO方式解析, 这样效率会更高、速度更快！

http://127.0.0.1/?pathinfo=off&m=api&c=index&a=index
           等同于↓
http://127.0.0.1/?m=api&c=index&a=index&pathinfo=off
```
#### 3.3 普通模式下的URL格式
> (1) 如何通过URL访问模块下的控制器方法?
```
# 示例: 访问Home模块下Index控制器index方法

http://127.0.0.1/?m=api&c=index&a=index
                  |     |       └───── 方法名Action (首字母必须是小写)
                  |     └───── 控制器名Controller (首字母可大小写)
                  └───── 模块名Module (首字母可大小写)
        等同于↓
http://127.0.0.1/
           └───── 没有指定 "方法名Action"、"控制器名Controller"、"模块名Module" 路由解析器会自动选取配置文件中定义默认的
```
> (2) 如何通过URL传递参数?
```
# 示例: 传递参数 id=28, name=dejan  给  Home模块下Index控制器的index方法

http://127.0.0.1/?m=api&c=index&a=index&id=28&name=dejan
                  |     |       └───── 方法名Action (首字母必须是小写)
                  |     └───── 控制器名Controller (首字母可大小写)
                  └───── 模块名Module (首字母可大小写)
        等同于↓
http://127.0.0.1/?id=28&name=dejan
           └───── 没有指定 "方法名Action"、"控制器名Controller"、"模块名Module" 路由解析器会自动选取配置文件中定义默认的
```
## 4. 模块 Module
#### 4.1 模块创建
> (1) 示例: 创建3个模块分别是: Api、Admin、Home   (注意:模块名首字母必须是大写的)
```
├─app  # 应用目录
│  ├─Api    # 新建模块1
│  ├─Admin  # 新建模块2
│  └─Home   # 新建模块3
│
└─weeio  # weeio-lite 框架核心目录
```
> (2) 修改 "路由配置文件" => /weeio/config/route.php  分别把新创建的模块名称加入到开放模块配置项中
```
# Weeio 路由配置

return array(
    ...

    'OPEN_MODULE' => [       # 开放模块  (注意: 新增的模块必须把模块名添加到该数组中)
        'Api'   => true,     # '模块名' => true
        'Admin' => true,
        'Home'  => true,
    ]
);
```
#### 4.2 模块应用的场景和作用
> 场景: 公司要做一个视频网站, 产品策划同事很快就设计好原型给到我们手上原型里有 网站前台、网站后台、移动端APP接口 ..  这时候想到的肯定是必须实现前后台网站分离、移动端API接口分离, 那该怎么做呢?

这时候我们就可以把 网站前台、网站后台、APP接口 看成独立的应用，即"模块Module"。然后划分成不同的"模块Module"来开发。

## 5. 控制器 Controller
#### 5.1 控制器创建
> 示例: 在 Home 模块目录下创建3个控制器    (注意: 控制器文件命名首字母必须是大小的)
```
├─app  # 应用目录
│  └─Home  # 模块目录
│      ├─Controller  # 控制器目录
│      │      Index.php    # 控制器1: 首页
│      │      Column.php   # 控制器2: 栏目
│      │      Article.php  # 控制器3: 文章


-- 控制器1:Index.php 文件内容
class Index
{
    public function index(){...}
}

-- 控制器2:Column.php 文件内容
class Column
{
    public function column(){...}
}

-- 控制器3:Article.php 文件内容
class Article
{
    public function article(){...}
}
```
#### 5.2 控制器方法中如何获取提交过来的GET、POST参数
```
# 方式1 :
/**
 * @param  $id    框架底层自动会提取返回相应的 $_POST['id'] 或 $_GET['id'] 值
 * @param  $name  框架底层自动会提取返回相应的 $_POST['name'] 或 $_GET['name'] 值
 */
public function test($id, $name = '未知')  # 该方式会自动选取$_POST或$_GET对应参数值, 如果$_POST或$_GET不一定提交某参数你还可以给他初始化
{
    echo "ID:{$id}, name:{$name}";
}
或  等同于↑
public function test($name = '未知', $id)  # 该方式自动选取$_POST或$_GET对应参数值是不分先后顺序的, 很高大上!
{
    echo "ID:{$id}, name:{$name}";
}

# 方式2 :
public function test()
{
    if(isset($_GET['id']) && isset($_GET['name']))
    {
        echo "ID:{$_GET['id']}, name:{$_GET['name']}";
    }
    else
    {
        echo "ID:{$_POST['id']}, name:{$_POST['name']}";
    }
}

```
#### 5.3 控制器方法中如何渲染视图
> 调用 $this->display() 方法渲染视图    (注意: 调用到 $this->display()、$this->assign($data) 方法, 该控制器必须继承weeio核心类)
```
<?php
namespace app\Home\Controller;

class Index extends \weeio\weeio     # 调用到 $this->display()、$this->assign($data) 方法, 该控制器必须继承weeio核心类
{
    public function test($id, $name)
    {
        $this->display(); # 视图渲染weeio默认会找到控制器方法相应view文件(注意:视图文件必须放在View下对应控制器目录下)
        //$this->display('test2.html'); # 当然也可以指定视图文件 , 但必须放在模块下View对应的控制器目录下
    }
}
```
#### 5.4 控制器方法将变量映射到视图中使用
> 调用 $this->assign() 将变量映射到视图中使用
```
<?php
namespace app\Home\Controller;

class Index extends \weeio\weeio      # 调用到 $this->display()、$this->assign($data) 方法, 该控制器必须继承weeio核心类
{
    public function test($id, $name)
    {
        $this->assign('name',$name); # 单个变量映射
        $this->assign('id',$id);

        $data = [
            'id' => $id,
            'name' => $name
        ];
        $this->assign($data); # 多个变量映射, 数组

        $this->display(); # 视图渲染weeio默认会找到控制器方法相应view文件(注意:视图文件必须放在View下对应控制器目录下)
        //$this->display('test2.html'); # 当然也可以指定视图文件 , 但必须放在模块下View对应的控制器目录下
    }
}
```
#### 5.5 控制器什么情况下需要继承weeio核心类
> 凡是调用到 $this->display()、$this->assign($data) 方法、$_Di实例对象, 控制器类必须继承weeio核心类。
## 6. 模型 Model
#### 6.1 模型创建

#### 6.2 自定义模型和使用

#### 6.3 数据库增删改查

## 7. 视图 View
#### 7.1 视图创建

#### 7.1 视图与控制器间参数传值

## 8. IOC容器(DI-依赖注入)
## 9. 框架扩展
## 10. 集成Composer
