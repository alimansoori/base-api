<?php
namespace Lib\Mvc;


use Phalcon\Cache\Backend;

abstract class CacheableModel extends Model
{
    protected static function _createKey($parameters)
    {
        $prefix = self::getPrefixCacheKey(get_called_class());

        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (is_array($value)) {
                $uniqueKey[] = $key . ':[' . self::_createKey($value) . ']';
            }
        }

        return $prefix. md5(join(',', $uniqueKey));
    }

    protected static function getPrefixCacheKey(string $className)
    {
        return str_replace('\\', '_', get_called_class()). '_';
    }

    protected static function _getCache($key)
    {

    }

    protected static function _setCache($key, $results)
    {

    }

    public static function find($parameters = null)
    {
        // Convert the parameters to an array
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Check if a cache key wasn't passed
        // and create the cache parameters
        if (!isset($parameters['cache'])) {
            $parameters['cache'] = [
                'key'      => self::_createKey($parameters),
                'lifetime' => 300,
            ];
        }

        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        // Convert the parameters to an array
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Check if a cache key wasn't passed
        // and create the cache parameters
        if (!isset($parameters['cache'])) {
            $parameters['cache'] = [
                'key'      => self::_createKey($parameters),
                'lifetime' => 300,
            ];
        }

        return parent::findFirst($parameters);
    }

    protected function deleteCacheKeys()
    {
        /** @var Backend $cache */
        $cache = $this->getDI()->get('modelsCache');
        foreach ($cache->queryKeys(self::getPrefixCacheKey(get_class($this))) as $key)
        {
            $cache->delete($key);
        }
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->deleteCacheKeys();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->deleteCacheKeys();
    }
}