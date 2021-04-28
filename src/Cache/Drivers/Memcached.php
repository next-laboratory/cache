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

    public function __construct($config, \Memcached $memcached)
    {
        $this->memcached = $memcached;
        $this->memcached->addServer($config['host'] ?? '127.0.0.1', $config['post'] ?? 11211);
    }

    /**
     * 返回memcached句柄
     * @return \Memcached
     */
    public function handle()
    {
        return $this->memcached;
    }

    public function get($key)
    {
        return $this->handle()->get($key);
    }

    public function set($key, $value, $ttl = NULL)
    {
        return $this->handle()->set($key, $value, $ttl);
    }

    public function has($key)
    {
    }


}
