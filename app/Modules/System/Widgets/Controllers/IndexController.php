<?php
namespace Modules\System\Widgets\Controllers;

use Lib\DTE\DTE;
use Lib\Messages\Message;
use Lib\Messages\Messages;
use Lib\Module\ModuleManager;
use Lib\Mvc\Controller;
use Modules\System\Widgets\DTE\Editor\EditorWidgets;
use Modules\System\Widgets\DTE\Table\TableRoutes;
use Modules\System\Widgets\DTE\Table\TableWidgets;

class IndexController extends Controller
{
    public function initialize()
    {
        $this->view->setMainView(THEME_PATH. 'ui/theme');
        $this->view->setLayoutsDir(THEME_PATH. 'ui/layouts/');
        $this->view->setPartialsDir(THEME_PATH. 'ui/partials/');

//        $this->assetsCollection->addCss('ilya-theme/ui/assets/themes/style1.css');

        $this->setBoxSize(100);
    }

    public function indexAction()
    {
        $dte1 = new DTE(
            null,
            new TableRoutes('table_routes'),
            'dte_routes'
        );

        $dte2 = new DTE(
            new EditorWidgets('editor_widgets'),
            new TableWidgets('table_widgets'),
            'dte_widgets'
        );

        $dte2->setParent($dte1, 'route_name', 'route_name');

        $dte1->process();
        $dte2->process();


        $this->view->dte1 = $dte1;
        $this->view->dte2 = $dte2;
//        dump($this->assetsCollection->getCodes());
//        dump($this->assetsCollection->getResources());
    }
}