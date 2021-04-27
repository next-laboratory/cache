<?php

namespace {

    if (false === function_exists('db')) {

        function cache(string $id)
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
     * @method static bool set(string $key, string $value, int $timeout = null)
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

