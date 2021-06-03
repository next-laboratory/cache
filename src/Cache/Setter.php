<?php
declare(strict_types=1);

namespace Max\Cache;

use Max\Foundation\App;

/**
 * @method get(string $key) 查询缓存
 * @method set(string $key, $value, $timeout = null) 查询缓存
 * Class Setter
 * @package Max\Cache
 */
class Setter
{
    /**
     * App示例
     * @var App $app
     */
    protected $app;

    /**
     * 驱动实例
     * @var mixed|object
     */
    protected $driver;

    /**
     * 驱动基础命名空间
     */
    const NAMESPACE = '\\Max\\Cache\\Drivers\\';

    /**
     * 实例化驱动
     * Setter constructor.
     * @param App $app
     */
    public function __construct($config)
    {
        $type   = $config['default'];
        $config = $config[$type];
        $driver       = self::NAMESPACE . ucfirst($type);
        $this->driver = new $driver($config);
    }

    /**
     * @param string $cacheCommand
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $cacheCommand, array $arguments)
    {
        return $this->driver->{$cacheCommand}(...$arguments);
    }
}
