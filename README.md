<br>

<p align="center">
<img src="https://raw.githubusercontent.com/topyao/max/master/public/favicon.ico" width="120" alt="Max">
</p>

<p align="center">轻量 • 简单 • 快速</p>

<p align="center">
<img src="https://img.shields.io/badge/php-%3E%3D7.2.0-brightgreen">
<img src="https://img.shields.io/badge/license-apache%202-blue">
</p>

# 起步
缓存组件已经独立，不再必须使用MaxPHP,你可以使用下面的命令安装开发版本

```
composer require max/cache:dev-master
```

# 使用

## 如果你在使用MaxPHP则需要按照下面的教程来使用

### 安装
使用起步中的命令安装完成后框架会自动将配置文件`cache.php`移动到根包的`config`目录下，如果创建失败，可以手动创建。

### 注册服务提供者
> 如果你在使用MaxPHP,需要注册服务提供者

在`/config/app.php` 的`provider`下的`http`中注册服务提供者类`\Max\CacheService::class`，当你注册了服务提供者，就会自动实例化`Setter`类并将类的实例存放进容器。

### 使用门面，依赖注入后者助手函数

```php
\Max\Facade\Cache::get($key); //门面

cache() //助手函数

//依赖注入
pubilc function index(Setter $setter){
    $setter->get('stat');
}
```

## 如果你没有使用MaxPHP，可以按照下面的方式使用

如果你使用文件缓存，安装好后你可能需要修改配置中的缓存存放路径，参考代码
```php
<?php

use Max\Cache\Setter;

require './vendor/autoload.php';
//配置文件
$config = include './vendor/max/cache/src/cache.php';
//初始化
$cache = new Setter($config);
//设置缓存
$cache->set('stat', 12, 10);
//读取缓存
var_dump($cache->get('stat'));

```

# 配置文件

文件内容如下：

```php
<?php

return [

    //默认缓存类型
    'default'   => 'file',

    // redis缓存
    'redis'     => [
        //主机
        'host'    => '127.0.0.1',
        //端口
        'port'    => 6379,
        //默认db
        'default' => 0,
        //连接超时时间
        'timeout' => 2,
        //认证用密码
        'auth'    => 'cheng',
        //连接失败后重新连接的次数
        'retry'   => 2
    ],

    //文件缓存
    'file'      => [],

    //memcached缓存
    'memcached' => [
        //主机
        'host' => '127.0.0.1',
        //端口
        'port' => 11211
    ]
];

```


> 官网：https://www.chengyao.xyz
