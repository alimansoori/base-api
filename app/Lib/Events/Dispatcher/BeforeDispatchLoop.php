<?php
namespace Lib\Events\Dispatcher;


use Lib\Acl\AbstractAcl;
use Lib\Acl\CheckAcl;
use Lib\Acl\DefaultAcl;
use Lib\Common\MobileDetect;
use Lib\Mvc\Dispatcher;
use Lib\Mvc\Helper;
use Modules\System\Users\Models\ModelUsers;
use Lib\Mvc\Router;
use Lib\Mvc\Router\Route;
use Lib\Mvc\View;
use Lib\Plugins\Localization;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Config;
use Phalcon\Events\EventInterface;
use Phalcon\Http\RequestInterface;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\ViewInterface;

class BeforeDispatchLoop
{
    protected $event;
    /** @var Router $router */
    protected $router;
    /** @var Route $route */
    protected $route;
    /** @var AbstractAcl $acl */
    protected $acl;
    protected $routeName;

    /**
     * @param EventInterface $event
     * @param DispatcherInterface|Dispatcher $dispatcher
     */
    public function __construct(EventInterface $event, DispatcherInterface $dispatcher)
    {
        $config = $dispatcher->getDI()->get('config');
        $response = $dispatcher->getDI()->get('response');
        $this->setDefaultContentType($config, $response);
        new Localization($dispatcher);


//        $this->event = $event;
//        $this->router = $dispatcher->getDI()->getShared('router');
//        $this->acl = $dispatcher->getDI()->getShared('acl');
//        $this->route = $this->router->getMatchedRoute();
//        $this->view = $dispatcher->getDI()->getShared('view');
//        $this->routeName = $this->route->getName();
//
//        $url = $this->slugWithoutLang($this->router->getRewriteUri());
//
//        /** @var ModelPages $page */
//        $page = ModelPages::findFirst([
//            'conditions' => 'slug=:slug: OR route=:route:',
//            'bind' => [
//                'slug' => substr($url, 1),
//                'route' => substr($this->route->getName(), 0, strpos($this->route->getName(), "__"))
//            ]
//        ]);
//
////        if(!$page && $this->route->getName() !== 'pages__'. ModelLanguage::getCurrentLanguage())
////        {
////            new CheckAcl($this->acl, $dispatcher, $this->view);
////            return;
////        }
//
//        /** @var ViewInterface $view */
//        $view = $dispatcher->getDI()->getShared('view');
//
//        $this->route->disableViewForJsonResponse($view);
//
//        if(!$page)
//        {
//            dump('Page not found <br><a href="/">Home Page</a>');
//        }
//
//        /** @var DefaultAcl $acl */
//        $acl = $this->router->getDI()->getShared('acl');
//
//        $access = false;
//        foreach(ModelUsers::getUserRolesForAuth() as $userRole)
//        {
//            if($acl->isAllowed(
//                $userRole,
//                $page->getId(),
//                '*'
//            ))
//            {
//                $access = true;
//                break;
//            }
//        }
//
//        if(!$access)
//        {
//            dump('Access denied');
//        }
//
//        $this->ajaxWidgetsRun($page);
//
//        $view->page = $page;
    }

    private function setDefaultContentType(Config $config, ResponseInterface $response)
    {
//        if ($config->rest->contentType)
//        {
//            $response->setHeader('content-type', $config->rest->contentType);
//        }
    }

    private function slugWithoutLang($slug)
    {
        $url = $this->router->getRewriteUri();

        if(substr($url, 1, strlen(ModelLanguage::getCurrentLanguage())) === ModelLanguage::getCurrentLanguage())
            $url = str_replace('/'.ModelLanguage::getCurrentLanguage(), '', $url);

        return $url;
    }

    private function ajaxWidgetsRun(ModelPages $pages)
    {
        /** @var RequestInterface $request */
        $request = $this->router->getDI()->get('request');
        if($request->isAjax())
        {
            /** @var ViewInterface $view */
            $view = $this->router->getDI()->getShared('view');
            /** @var Helper $helper */

            $view->disable();

            $this->getWidgets($pages);
        }
    }

    private function getWidgets(ModelPages $page)
    {
        $helper = $this->router->getDI()->getShared('helper');

        /** @var MobileDetect $device */
        $device = $this->router->getDI()->get('device');

        /** @var ModelWidgetPlaces $place */
        foreach (ModelWidgetPlaces::find() as $place)
        {
            /** @var ModelPageWidgetPlaceMap $pagePlaceMap */
            $pagePlaceMap = $place->getPageWidgetPlaceMaps([
                'conditions' => 'page_id=:page_id:',
                'bind' => [
                    'page_id' => $page->getId()
                ]
            ])->getFirst();

            if (!$pagePlaceMap)
            {
                return [];
            }

            if ($device->isTablet())
            {
                /** @var ModelWidgetViewTablet[] $widgetViewDevice */
                $widgetViewDevice = $pagePlaceMap->getWidgetViewTablet([
                    'order' => 'row, column'
                ]);
            }
            elseif ($device->isMobile())
            {
                /** @var ModelWidgetViewMobile[] $widgetViewDevice */
                $widgetViewDevice = $pagePlaceMap->getWidgetViewMobile([
                    'order' => 'row, column'
                ]);
            }
            else
            {
                /** @var ModelWidgetViewDesktop[] $widgetViewDevice */
                $widgetViewDevice = $pagePlaceMap->getWidgetViewDesktop([
                    'order' => 'row, column'
                ]);
            }

            $widgetinstances = [];

            foreach ($widgetViewDevice as $widgetView)
            {
                if ($widgetView->getWidgetId() && !isset($widgetinstances[$widgetView->getWidgetInstance()->getId()]))
                {
                    $helper->widget($widgetView->getWidgetInstance()->getWidget()->getNamespace())->run($widgetView->getWidgetInstance(), []);
                }
            }
        }
    }
}