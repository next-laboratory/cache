<?php

namespace Max\Facade;

/**
 * @method static string get(string $key)
 * @method static bool has(string $key)
 * @method static bool set(string $key, string $value, int $ttl = null)
 * @method static bool delete(string $key)
 * @method static bool clear()
 * @method static \Redis handle()
 * Class Cache
 * @package Max\Facade
 */
class Cache extends Facade
{

    protected static function getFacadeClass()
    {
        return 'cache';
    }
    
}
