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

