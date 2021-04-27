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

    public function __construct()
    {
        $this->path = env('cache_path') . 'app' . DIRECTORY_SEPARATOR;
        \Max\Tools\File::mkdir($this->path);
    }

    public function has(string $key)
    {
        return file_exists($this->path . strtolower($key));
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return file_get_contents($this->path . strtolower($key));
        }
        throw new \InvalidArgumentException('Cache not found: ' . $key, 999);
    }

    /**
     * 缓存设置
     * @param string $key
     * @param string $value
     * @return false|int
     * false 写入失败，int 写入的字节
     */
    public function set(string $key, string $value)
    {
        return file_put_contents($this->path . strtolower($key), $value);
    }
}
