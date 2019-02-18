<?php
namespace Lib\Mvc\Helper;

use Phalcon\Mvc\User\Component;

class Locale extends Component
{
    private static $instance;
    private static $language = 'en';
    private static $direction = 'ltr';

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new Locale();
        }
        return self::$instance;
    }

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return self::$language;
    }

    /**
     * @param string $language
     */
    public function setLanguage( $language )
    {
        self::$language = $language;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return self::$direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection( $direction )
    {
        self::$direction = $direction;
    }

    private function getLangDefault($languages)
    {
        $langDefault = null;
        if (is_array($languages) || $languages instanceof \Traversable)
        {
            foreach ($languages as $language)
            {
                if ($language['is_primary'])
                {
                    $langDefault = $language;
                    break;
                }
            }
        }

        return $langDefault;
    }
}