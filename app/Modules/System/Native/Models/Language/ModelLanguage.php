<?php
/**
 * Summary File ModelLanguage
 *
 * Description File ModelLanguage
 *
 * ILYA CMS Created by ILYA-IDEA Company.
 * @author Ali Mansoori
 * Date: 10/11/2018
 * Time: 6:08 PM
 * @version 1.0.0
 * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
 */
namespace Modules\System\Native\Models\Language;

use Lib\Mvc\Helper\CmsCache;
use Lib\Mvc\Model;

class ModelLanguage extends Model
{
    use TraitPropertiesLanguage;
    use TraitValidationLanguage;
    use TraitEventsLanguage;
    use TraitRelationsLanguage;

    protected static $currentLanguage = 'en';

    protected function init()
    {
        $this->setSource('language');
    }

    public static function getMainLanguage()
    {
        if(is_null(CmsCache::getInstance()->get('languages')) &&
            !is_array(CmsCache::getInstance()->get('languages')))
        {
            CmsCache::getInstance()->save('languages', self::buildCmsLanguagesCache());
        }

        foreach(CmsCache::getInstance()->get('languages') as $lang)
        {
            if(!$lang['is_primary'])
                continue;

            return $lang['iso'];
            break;
        }
    }

    public static function getLanguages()
    {
        if(is_null(CmsCache::getInstance()->get('languages')) &&
            !is_array(CmsCache::getInstance()->get('languages'))
        )
        {
            CmsCache::getInstance()->save('languages', self::buildCmsLanguagesCache());
        }

        return array_keys(
            CmsCache::getInstance()->get('languages')
        );
    }

    public static function getCurrentLanguage()
    {
        $route = ( new ModelLanguage )->getDI()->get('router')->getMatchedRoute();

        if($route && isset($route->getPaths()['lang']))
        {
            return $route->getPaths()['lang'];
        }
         return self::$currentLanguage;
    }

    public static function setCurrentLanguage($lang)
    {
        self::$currentLanguage = $lang;
    }

    public static function getCurrentDir()
    {
        if(is_null(CmsCache::getInstance()->get('languages')) &&
            !is_array(CmsCache::getInstance()->get('languages')))
        {
            CmsCache::getInstance()->save('languages', self::buildCmsLanguagesCache());
        }

        return CmsCache::getInstance()->get('languages')[self::getCurrentLanguage()]['direction'];
    }

    public static function hasLanguage($lang = null)
    {
        if (in_array($lang, self::getLanguages()))
        {
            return true;
        }

        return false;
    }
}