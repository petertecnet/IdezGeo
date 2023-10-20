<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function get($key)
    {
        return Cache::get($key);
    }
 
    public function put($key, $value, $minutes)
    {
        Cache::put($key, $value, $minutes);
    }
}
