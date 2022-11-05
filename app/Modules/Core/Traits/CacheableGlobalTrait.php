<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-02-15 21:01:13
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 11:31:10
 * @ Description: Happy Coding!
 */


namespace App\Modules\Core\Traits;

use ReflectionObject;
use Exception;

trait CacheableGlobalTrait
{
    protected $enableCache = true;
    
    protected $cache;
    /**
     * @var string The entity name
     */
    protected $entityName;
    /**
     * @var string The application locale
     */
    protected $locale;

    /**
     * @var int caching time
     */
    protected $cacheTime;

    public function clearCache()
    {
        $store = $this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags($this->entityName);
        } else {
            $this->cache->flush();
        }

        return $store->flush();
    }

    /**
     * @param \Closure $callback
     * @param null|string $key
     * @return mixed
     */
    protected function remember(\Closure $callback, $key = null, $excludes = [], $debug = 0)
    {
        if(!$this->enableCache) {
            return $callback();
        }
        
        $cacheKey = $this->makeCacheKey($key, $excludes, $debug);

        $store = $this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags([$this->entityName, 'global']);
        }

        return $store->remember($cacheKey, $this->cacheTime, $callback);
    }

    /**
     * Generate a cache key with the called method name and its arguments
     * If a key is provided, use that instead
     * @param null|string $keyß
     * @return string
     */
    public function makeCacheKey($key = null, $excludes = [], $debug = 0): string
    {
        if ($key !== null) {
            return $key;
        }

        $cacheKey = $this->getBaseKey();

        $backtrace = debug_backtrace()[2];

        if ($debug) {
            dd($backtrace);
        }

        if (!empty($excludes)) {
            $backtrace['args'] = array_filter($backtrace['args'], function ($k) use ($excludes) {
                return !in_array($k, $excludes);
            }, ARRAY_FILTER_USE_KEY);
        }

        try {
            return sprintf("$cacheKey %s %s", $backtrace['class'] . ':' . $backtrace['function'], \serialize($backtrace['args']));
        } catch (Exception $e) {
            // throw $e;
            // We want to take care of the closure serialization errors,
            // other than that we will simply re-throw the exception.
            if ($e->getMessage() !== "Serialization of 'Closure' is not allowed") {
                // throw $e;
            }
            // dd($backtrace['args']);

            // $r = new ReflectionObject($backtrace['args']);

            return sprintf("$cacheKey %s %s", $backtrace['class'] . ':' . $backtrace['function'], '');
        }
    }

    /**
     * @return string
     */
    protected function getBaseKey(): string
    {
        return sprintf(
            env('APP_DOMAIN') . ' -Oops!Memory -locale:%s -entity:%s',
            $this->locale,
            $this->entityName
        );
    }
}
