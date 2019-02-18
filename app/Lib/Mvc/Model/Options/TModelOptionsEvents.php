<?php
namespace Lib\Mvc\Model\Options;


use Lib\Mvc\Helper\CmsCache;

trait TModelOptionsEvents
{
    public function afterSave()
    {
        parent::afterSave();
        CmsCache::getInstance()->save('options', $this->buildOptionsCache());
    }

    public function afterDelete()
    {
        parent::afterDelete();
        CmsCache::getInstance()->save('options', $this->buildOptionsCache());
    }

    private function buildOptionsCache()
    {
        $options = self::find();

        $save = [];

        /** @var self $option */
        foreach($options as $option)
        {
            $save[$option->getKey()] = $option->getValue();
        }

        return $save;
    }
}