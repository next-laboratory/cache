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


namespace Max {

    use Max\Cache\Setter;
    use Max\Contracts\Service;

    class CacheService extends Service
    {

        public function register()
        {
            $this->app->bind('cache', \Max\Cache\Setter::class);
        }

        public function boot()
        {
            $config = $this->app->config->get('cache');
            $setter = new Setter($config);
            $this->app->set(Setter::class, $setter);
        }

    }

}


