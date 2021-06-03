<?php
declare(strict_types=1);

namespace Max\Cache;

/**
 * @method get(string $key) 查询缓存
 * @method set(string $key, $value, int $ttl = null) 查询缓存
 * @method bool has(string $key) 判断是否有缓存
 * @method bool delete(string $key) 删除缓存
 * @method bool clear() 清空缓存
 * Class Setter
 * @package Max\Cache
 */
class Setter
{

    /**
     * 驱动实例
     * @var object
     */
    protected $driver;

    /**
     * 驱动基础命名空间
     */
    const NAMESPACE = '\\Max\\Cache\\Drivers\\';

    /**
     * Setter constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $type         = $config['default'];
        $driver       = self::NAMESPACE . ucfirst($type);
        $this->driver = new $driver($config[$type]);
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
