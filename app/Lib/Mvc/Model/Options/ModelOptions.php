<?php
namespace Lib\Mvc\Model\Options;

use Lib\Exception;
use Lib\Mvc\Helper\CmsCache;
use Lib\Mvc\Model;
use Phalcon\Di;
use Phalcon\Validation\Validator\Uniqueness;

class ModelOptions extends Model
{
    use TModelOptionsProperties;
    use TModelOptionsEvents;

    protected function init()
    {
        $this->setDbRef(true);
        $this->setSource('options');

    }

    public static $keys = [
        'DEBUG_MODE'        => 1,
        'TECHNICAL_WORKS'   => 1,
        'PROFILER'          => 1,
        'WIDGETS_CACHE'     => 1,
        'DISPLAY_CHANGELOG' => 1,
        'ADMIN_EMAIL'       => 'webmaster@localhost',
    ];

    protected function mainValidation()
    {
        $this->validator->add(
            'key' ,
            new Uniqueness([
                'model' => $this
            ])
        );
    }

    public static function findCacheByKey($key)
    {
        if(CmsCache::getInstance()->get('options'))
        {
            if(strlen($key))
            {
                if(array_key_exists($key, CmsCache::getInstance()->get('options')))
                    return CmsCache::getInstance()->get('options')[$key];
            }
        }

        /** @var self $option */
        $option = self::findFirst([
            'conditions' => 'key = :key:',
            'bind' => [
                'key' => $key
            ]
        ]);
        if($option)
        {
            return $option->getValue();
        }

        return null;
    }

    /**
     * @param $key
     * @param string|integer|boolean|null $default
     * @return mixed
     * @throws Exception
     */
    public static function getOption($key, $default = null)
    {
        if (CmsCache::getInstance()->get('options'))
        {
            $options = CmsCache::getInstance()->get('options');
            if (!$options[$key])
            {
                if (!is_null($default))
                    return $default;

                return false;
//                throw new Exception("Key $key does not exist in cache");
            }

            return $options[$key];
        }

        /** @var ModelOptions $option */
        $option = self::findFirstByKey($key);

        if (!$option)
        {
            if (!is_null($default))
                return $default;

            return false;
//            throw new Exception("Option $key does not exist in db");
        }

        return $option->getValue();
    }

    /**
     * @param string $key
     * @param string|integer|bool $value
     * @param bool $transactions
     * @throws Exception
     */
    public static function setOption(string $key, $value = null, $transactions = true)
    {
        if (!(is_null($value) || is_string($value) || is_integer($value)))
        {
            throw new Exception('Invalid value param type in setOption');
        }

        /** @var ModelOptions $option */
        $option = self::findFirstByKey($key);

        if (!$option)
        {
            $option = new self();
            $option->setKey($key);
        }

        if ($transactions)
            $option->setTransaction(Di::getDefault()->get('transactions'));

        $option->setValue($value);

        if (!$option->save())
        {
            if ($option->hasTransaction())
            {
                $option->getTransaction()->rollback('rollback save option');
            }
            else
            {
                throw new Exception('Option does not save');
            }
        }
    }
}