<?php
declare(strict_types=1);

namespace Max\Cache;

use Psr\SimpleCache\CacheInterface;

abstract class Driver implements CacheInterface
{

    /**
     * 检查key是否是一个合法的类型
     * @param $key
     * @return $this
     */
    protected function _checkKey($key)
    {
        if (false === is_scalar($key)) {
            throw new InvalidArgumentException();
        }
        return $this;
    }

    public function delete($key)
    {
    }

    public function clear()
    {
    }

    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

}
