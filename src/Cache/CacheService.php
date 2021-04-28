<?php

namespace {

    use Max\Cache\Setter;

    if (false === function_exists('cache')) {
        /**
         * Cache操作
         * @return Setter
         */
        function cache()
        {
            return app('cache');
        }
    }
}


namespace Max\Cache {

    use Max\Contracts\Service;

    class CacheService implements Service
    {

        public function register()
        {
            app()->bind('cache', Setter::class);
        }

        public function boot()
        {
            app('config')->load('cache');
        }

    }
}

namespace Max\Facade {

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
}

