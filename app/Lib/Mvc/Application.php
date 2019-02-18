<?php
namespace Lib\Mvc;


use Ilya\Services;
use Lib\Acl\AbstractAcl;
use Lib\Common\Strings;
use Lib\Events\Application\AfterHandleRequest;
use Lib\Events\Application\AfterStartModule;
use Lib\Events\Application\BeforeHandleRequest;
use Lib\Events\Application\BeforeSendResponse;
use Lib\Events\Application\BeforeStartModule;
use Lib\Events\Application\Boot;
use Lib\Events\Application\ViewRender;
use Lib\Module\ModuleManager;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Phalcon\Events\EventInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\ControllerInterface;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\ViewInterface;

class Application extends \Phalcon\Mvc\Application
{
    /**
     * Application constructor.
     * Loads the modules and initializes their routs
     * @param \Phalcon\DiInterface|null|Services $di
     */
    public function __construct(\Phalcon\DiInterface $di = null)
    {
        parent::__construct($di);
        $this->registerModules(ModuleManager::getAllModules());

        $this->setCurrentLanguage();
        $this->setEventsManager($di->getShared('eventsManager'));
        $this->setEvents();

        $this->initRoute($di);

        $di->afterInitServices();
    }

    private function setCurrentLanguage()
    {
        $url = $_SERVER['REQUEST_URI'];
        $baseUrl = $this->getDI()->get('url')->getBaseUri();
        if($baseUrl)
        {
            $countBaseUrl = strlen($baseUrl);
            $countUrl = strlen($url);
            $length = -($countUrl - $countBaseUrl);

            $url = substr($url, $length);
        }

        $lang = substr($url, 0, 2);
        if(strlen($url) > 2)
        {
            $langSlash = substr($url, 0, 3);

            if(Strings::IsEndBy($langSlash, '/'))
            {
                if(!in_array($lang, ModelLanguage::getLanguages()))
                    ModelLanguage::setCurrentLanguage(ModelLanguage::getMainLanguage());
                else
                    ModelLanguage::setCurrentLanguage($lang);
            }
            else
                ModelLanguage::setCurrentLanguage(ModelLanguage::getMainLanguage());
        }
        elseif(strlen($url) == 2)
        {
            if(!in_array($lang, ModelLanguage::getLanguages()))
                ModelLanguage::setCurrentLanguage(ModelLanguage::getMainLanguage());
            else
                ModelLanguage::setCurrentLanguage($lang);
        }
        else
        {
            ModelLanguage::setCurrentLanguage(ModelLanguage::getMainLanguage());
        }
    }

    /**
     * Summary Function initRoute
     * Sets the modules Routs
     * @param \Phalcon\DiInterface $di
     */
    private function initRoute(\Phalcon\DiInterface $di)
    {
        $router = new Router();

        foreach ($this->getModules() as $moduleName=>$module)
        {
            $this->registerModulesRoutesClass($module, $router, $moduleName);
            $this->registerModulesInitClass($module, $moduleName);
        }

        $router->setEventsManager($di->getShared('eventsManager'));
        $router->setEvents();

        $di->set('router', $router);
    }

    /**
     * @param $module
     * @param $router
     * @return mixed
     */
    private function registerModulesRoutesClass($module, $router, $moduleName)
    {
        $routesClassName = str_replace('\Module', '\Routes', $module['className']);

        if (file_exists(str_replace('Module.php', 'Routes.php', $module['path'])))
        {
            include_once str_replace('Module.php', 'Routes.php', $module['path']);
            if (class_exists($routesClassName))
            {
//                return new $routesClassName($router);
                return new $routesClassName($this->getDI(), $router, str_replace('Module.php', '', $module['path']), $moduleName, str_replace('\Module', '', $module['className']));
            }
        }
    }

    /**
     * @param $module
     */
    private function registerModulesInitClass($module, $moduleName)
    {
        $initClassName = str_replace('\Module', '\Init', $module['className']);
        if (file_exists(str_replace('Module.php', 'Init.php', $module['path'])))
        {
            include str_replace('Module.php', 'Init.php', $module['path']);
            if (class_exists($initClassName)) {
                new $initClassName($this->getDI(), str_replace('Module.php', '', $module['path']), $moduleName, str_replace('\Module', '', $module['className']));
            }
        }
    }

    public function setEvents()
    {
        $eventsManager = $this->getEventsManager();
        if(!$eventsManager instanceof ManagerInterface)
            return false;

        $eventsManager->attach('application:afterHandleRequest', function(EventInterface $event, Application $application, ControllerInterface $controller) {
            new AfterHandleRequest($event, $application, $controller);
        });
        $eventsManager->attach('application:afterStartModule', function(EventInterface $event, Application $application, ModuleDefinitionInterface $moduleObject) {
            new AfterStartModule($event, $application, $moduleObject);
        });
        $eventsManager->attach('application:beforeHandleRequest', function(EventInterface $event, Application $application, DispatcherInterface $dispatcher) {
            new BeforeHandleRequest($event,$application, $dispatcher);
        });
        $eventsManager->attach('application:beforeSendResponse', function(EventInterface $event, Application $application, ResponseInterface $response) {
            new BeforeSendResponse($event, $application, $response);
        });
        $eventsManager->attach('application:beforeStartModule', function(EventInterface $event, Application $application, $moduleName) {
            new BeforeStartModule($event, $application, $moduleName);
        });
        $eventsManager->attach('application:boot', function(EventInterface $event, Application $application) {
            new Boot($event, $application);
        });
        $eventsManager->attach('application:viewRender', function(EventInterface $event, Application $application, ViewInterface $view) {
            new ViewRender($event, $application, $view);
        });
    }
}