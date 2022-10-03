<?php

namespace Pictorial;

class Cache
{
    protected $cache = null;

    function __construct()
    {
        $this->cache = new Memcache;
    }

    public function store($key, $data, $expiry = 0)
    {
        if(empty($key) || empty($data))
        {
            return false;
        }

        $flag = 0;

        return $this->cache->set($key, $data, $flag, $expiry);
    }

    public function retrieve($key)
    {
        if(empty($key))
        {
            return null;
        }

        $data = $this->cache->get($key);

        return ($data === false ? null : $data);
    }

    public function delete($key)
    {
        if(empty($key))
        {
            return false;
        }

        return $this->cache->delete($key);
    }

    public function flush()
    {
        return $this->cache->flush();
    }
}

?>
