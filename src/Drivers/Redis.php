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
    public function set(string $key, string $value, int $timeout = null)
    {
        return $this->handle()->set($key, $value, $timeout);
    }

    /**
     * 获取
     * @param string $key
     * @return bool|mixed|string
     */
    public function get(string $key)
    {
        return $this->handle()->get($key);
    }

    /**
     * 存在判断
     * @param string $key
     * @return bool|int
     */
    public function has(string $key)
    {
        return $this->handle()->exists($key);
    }
}
