<?php
declare(strict_types=1);

namespace Max\Cache\Drivers;

use Max\Cache\Driver;

/**
 * Class Memcached
 * @package Max\Cache\Drivers
 */
class Memcached extends Driver
{

    /**
     * Memcached实例
     * @var \Memcached
     */
    private $memcached;

    /**
     * 连接服务器
     * Memcached constructor.
     * @param $config
     * @param \Memcached $memcached
     */
    public function __construct($config, \Memcached $memcached)
    {
        $this->memcached = $memcached;
        $this->memcached->addServer($config['host'] ?? '127.0.0.1', $config['post'] ?? 11211);
    }

    /**
     * 删除Memcached缓存
     * @param string $key
     * 缓存的键
     * @return bool|void
     */
    public function delete($key)
    {
        return $this->handle()->delete($key);
    }


    /**
     * 返回memcached句柄
     * @return \Memcached
     */
    public function handle()
    {
        return $this->memcached;
    }

    /**
     * 获取缓存
     * @param string $key
     * @param null $default
     * @return mixed|void
     */
    public function get($key, $default = NULL)
    {
        return $this->handle()->get($key);
    }

    /**
     * 设置缓存
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool|void
     */
    public function set($key, $value, $ttl = NULL)
    {
        return $this->handle()->set($key, $value, $ttl);
    }

    /**
     * 存在判断
     * @param string $key
     * @return bool|void
     */
    public function has($key)
    {
        return $this->handle()->get($key) ? true : false;
    }


}
