<?php
declare(strict_types=1);

namespace Max\Cache;

use Max\Foundation\App;

/**
 * @method get(string $key) 查询缓存
 * @method set(string $key, $value, $timeout) 查询缓存
 * Class Setter
 * @package Max\Cache
 */
class Setter
{
    protected $driver;

    protected $app;

    const NAMESPACE = '\\Max\\Cache\\Drivers\\';

    public function __construct(App $app)
    {
        $this->app    = $app;
        $this->driver = $app->make(
            self::NAMESPACE . ucfirst($app->config->get('cache.default')),
            [$app->config->getDefault('cache')]
        );
    }

    /**
     * @param $cacheCommand
     * @param $data
     * @return mixed
     */
    public function __call($cacheCommand, $data)
    {
        return $this->driver->{$cacheCommand}(...$data);
    }
}
