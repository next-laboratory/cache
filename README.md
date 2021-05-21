<br>

<p align="center">
<img src="https://raw.githubusercontent.com/topyao/max/master/public/favicon.ico" width="120" alt="Max">
</p>

<p align="center">轻量 • 简单 • 快速</p>

<p align="center">
<img src="https://img.shields.io/badge/php-%3E%3D7.2.0-brightgreen">
<img src="https://img.shields.io/badge/license-apache%202-blue">
</p>

Max框架缓存组件

# 安装

```
composer require max/cache:dev-master
```

# 使用

## 注册服务提供者

在`/config/provider.php` 的`http`中注册服务提供者类`\Max\CacheService::class`

## 配置文件

安装完成后框架会自动将配置文件`cache.php`移动到根包的`config`目录下，如果创建失败，可以手动创建。

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
    'file'      => [
        //默认的过期时间
        'expire' => 0
    ],

    //memcached缓存
    'memcached' => [
        //主机
        'host' => '127.0.0.1',
        //端口
        'port' => 11211
    ]
];

```

## 助手函数

安装完成后就可以使用`\Max\Facade\Cache::get($key);`等的方式来使用缓存扩展，或者使用助手函数`cache()`

> 官网：https://www.chengyao.xyz
