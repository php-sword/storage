PHP-Sword Storage 0.1.0
===============

> 多种方式的对象储存管理封装组件包，支持本地、Oss、PHP-Api方式自由切换。

## 主要特性

* 采用`PHP7`强类型（严格模式）
* 支持更多的`PSR`规范
* 多种方式的自由切换

## 安装

~~~
composer require php-sword/storage
~~~

## 文档

全局单例注册
```php
Storage::getInstance($config);
```

配置信息
```php
$config = [

    //资源储存方式 local|alioss|api
    'drive' => 'api',

    //资源api服务器接口配置 -若res_type=local生效
    'dev_local' => [
        // 资源目录路径 以/结尾
        'public' => EASYSWOOLE_ROOT. '/Public/'
    ],

    //资源api服务器接口配置 -若res_type=api生效
    // 接口服务端代码：https://github.com/php-sword/storage/blob/main/tests/api.php
    'dev_api' => [
        'Host' => 'ac.youhost.cn',
        'Port' => 80,
        'Gateway' => '/api.php',
        'User' => 'xoshe',
        'Secret' => '***',
        'OutTime' => -1
    ],

    // 阿里oss配置 -若res_type=alioss生效
    'dev_alioss' => [
        'AccessKey'   => 'LTA***sZh',
        'Secret'      => 'NSc38*****fn7z5',
        'Endpoint'    => "http://oss-cn-chengdu.aliyuncs.com",
        'Bucket'      => '***'
    ],
];
```

使用
```php
$storage = Storage::getInstance()->getObject();
$storage->upload(...);
```

若是采用api方式：
接口服务端代码：https://github.com/php-sword/storage/blob/main/tests/api.php

## 参与开发

> 直接提交PR或者Issue即可

## 版权信息

本项目遵循Apache2.0开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
