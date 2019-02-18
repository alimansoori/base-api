<?php
/**
 * Summary File Localization
 *
 * Description File Localization
 *
 * ILYA CMS Created by ILYA-IDEA Company.
 * @author Ali Mansoori
 * Date: 8/18/2018
 * Time: 9:33 PM
 * @version 1.0.0
 * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
 */
namespace Lib\Plugins;

use Lib\Mvc\Helper;
use Lib\Mvc\Helper\CmsCache;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;
use Lib\Translate\Adapter\NativeArray;

/**
 * Summary Class Localization
 *
 * Description Class Localization
 *
 * @author Ali Mansoori
 * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
 * @package Lib\Plugins
 * @version 1.0.0
 * @example Desc <code></code>
 * @property Helper $helper
 */
class Localization extends Plugin
{
    public function __construct (Dispatcher $dispatcher)
    {
        ModelLanguage::setCurrentLanguage('en');

        if($this->request->getHeader('Accept-Language'))
        {
            if (ModelLanguage::hasLanguage(
                $this->request->getHeader('Accept-Language')
            ))
            {
                ModelLanguage::setCurrentLanguage(
                    $this->request->getHeader('Accept-Language')
                );
            }
        }

        $this->response->setHeader('lang', ModelLanguage::getCurrentLanguage());
        $this->response->setHeader('dir', ModelLanguage::getCurrentDir());
    }
}