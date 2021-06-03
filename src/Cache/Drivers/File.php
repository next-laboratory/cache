<?php
declare(strict_types=1);

namespace Max\Cache\Drivers;

use Max\Cache\Driver;

class File extends Driver
{

    /**
     * 缓存路径
     * @var string
     */
    protected $path;

    /**
     * 缓存容器
     * @var array
     */
    protected $cache = [];

    /**
     * 初始化
     * File constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        if (file_exists($path = $config['path'])) {
            if (is_file($path)) {
                throw new \Exception('已经存在同名文件，不能创建文件夹!');
            }
        } else {
            mkdir($path, 0777, true);
        }
        $this->path = rtrim($path, DIRECTORY_SEPARATOR) . '/';
    }

    /**
     * 缓存存在判断
     * @param string $key
     * @return bool|void
     */
    public function has($key)
    {
        $cacheFile = $this->getFile($key);
        if (file_exists($cacheFile)) {
            $expire = (int)unserialize($this->getCache($cacheFile))[0];
            if (0 !== $expire && filemtime($cacheFile) + $expire < time()) {
                $this->remove($key);
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * 删除文件缓存，缓存不存在直接返回true
     * @param string $key
     * @return bool|void
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            return $this->remove($key);
        }
        return true;
    }

    /**
     * 文件缓存设置
     * @param string $key
     * @param null $default
     * @return false|mixed|string|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return unserialize($this->getCache($this->getFile($key)))[1];
        }
        return $default;
    }

    /**
     * 设置缓存
     * @param string $key
     * 缓存名称
     * @param mixed $value
     * 缓存值
     * @param null $ttl
     * 缓存有效期
     * @return false|int
     * false 写入失败，int 写入的字节
     */
    public function set($key, $value, $ttl = NULL)
    {
        return file_put_contents($this->getFile($key), serialize([(int)$ttl, $value]));
    }

    /**
     * 清空cache
     * @return bool|void
     */
    public function clear()
    {

    }

    /**
     * 取得缓存内容，如果不存在会从文件中取得，否则在内存中取
     * @param $cacheFile
     * @return mixed
     */
    protected function getCache($cacheFile)
    {
        if (!isset($this->cache[$cacheFile])) {
            if (false === ($value = file_get_contents($cacheFile))) {
                throw new \InvalidArgumentException('Cache not found: ' . $cacheFile, 999);
            }
            $this->cache[$cacheFile] = $value;
        }
        return $this->cache[$cacheFile];
    }

    /**
     * 缓存hash
     * @param string $key
     * @return string
     */
    protected function getID(string $key)
    {
        return md5(strtolower($key));
    }

    /**
     * 删除某一个缓存，必须在已知缓存存在的情况下调用，否则会报错
     * @param $key
     * @return bool
     */
    protected function remove($key)
    {
        return unlink($this->getFile($key));
    }

    /**
     * 根据key获取文件
     * @param $key
     * @return string
     */
    protected function getFile($key)
    {
        return $this->path . $this->getID($key);
    }

}
