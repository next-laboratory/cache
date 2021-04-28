<?php
declare(strict_types=1);

namespace Max\Cache\Drivers;

use Max\Cache\Driver;

/**
 * Class Redis
 * @package Max\Cache\Drivers
 */
class Redis extends Driver
{

    /**
     * Redis实例
     * @var \Redis
     */
    protected $redis;

    /**
     * 查询次数
     * @var int
     */
    protected $count = 0;

    /**
     * 连接重试次数
     * @var int|mixed
     */
    protected $retryTimes = 0;

    /**
     * 初始化Redis,建立连接
     * Redis constructor.
     * @param $config
     * @param \Redis $redis
     * @throws \Exception
     */
    public function __construct($config, \Redis $redis)
    {
        $this->redis      = $redis;
        $this->retryTimes = $config['retry'] ?? 0;
        $this->connect($config)
            ->auth($config['auth'] ?? null)
            ->select($config['default'] ?? 0);
    }

    /**
     * 认证
     * @param $pass
     * @return \Redis
     */
    public function auth($pass)
    {
        if (!empty($pass)) {
            $this->redis->auth($pass);
        }
        return $this->redis;
    }


    /**
     * 选择数据库
     * @param int $id
     */
    public function select(int $id)
    {
        if (0 !== $id) {
            $this->redis->select($id);
        }
        return $this->handle();
    }

    /**
     * 获取执行命令的次数
     * @return int
     */
    public function getExecedTimes()
    {
        return $this->count;
    }

    /**
     * 连接Redis
     * @param $config
     * @return $this
     * @throws \Exception
     */
    public function connect($config)
    {
        try {
            $this->redis->connect($config['host'] ?? '127.0.0.1', $config['port'] ?? 6379, $config['timeout'] ?? 5);
        } catch (\Exception $e) {
            if (0 == $this->retryTimes--) {
                $retry = $config['retry'] ?? 0;
                throw new \Exception($e->getMessage() . "[Retried for {$retry} times]", $e->getCode());
            }
            return $this->connect($config);
        }
        return $this;
    }

    /**
     * Redis句柄
     * @return \Redis
     */
    public function handle()
    {
        $this->count++;
        return $this->redis;
    }

    /**
     * 设置
     * @param string $key
     * @param $value
     * @param int|null $timeout
     * @return bool
     */
    public function set($key, $value, $ttl = NULL)
    {
        return $this->_checkKey($key)
            ->handle()
            ->set($key, $value, $ttl);
    }


    /**
     * Redis缓存获取
     * @param string $key
     * @param null $default
     * @return bool|mixed|string|null
     * @throws InvalidArgumentException
     */
    public function get($key, $default = NULL)
    {
        if (false === ($value = $this->_checkKey($key)->handle()->get($key))) {
            return $default;
        }
        return $value;
    }

    /**
     * 删除一个缓存
     * @param string $key
     * 标量的key
     * @return bool|void
     */
    public function delete($key)
    {
        return $this->_checkKey($key)
            ->handle()
            ->del($key) ? true : false;
    }

    /**
     * 存在判断
     * @param string $key
     * @return bool|int
     */
    public function has($key)
    {
        return $this->handle()->exists($key);
    }


    /**
     * 删除所有缓存
     * @return bool|void
     */
    public function clear()
    {
        return $this->handle()->flushAll();
    }

}
