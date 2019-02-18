<?php
namespace Modules\CreateContent\Ad\Controllers;


use Lib\Mvc\Controller;

class AdsController extends Controller
{
    public function indexAction()
    {
        $this->assets->collection('head')->addJs('assets/jquery/dist/jquery.min.js');
        $this->assetsCollection->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        $this->assetsCollection->addCss('css/semantic-ui/loader.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsCollection->addCss('dt/css/editor.dataTables.min.css');
        $this->assetsCollection->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-select/js/dataTables.select.min.js');

        $this->assetsCollection->addJs('assets/select2/dist/js/select2.min.js');
        $this->assetsCollection->addCss('assets/select2/dist/css/select2.min.css');
        $this->assetsCollection->addJs('dt/js/editor.select2.js');
        $this->assetsCollection->addJs('dt/js/editor.select-range.js');
        $this->assetsCollection->addJs('dt/js/editor.range.js');
        $this->assetsCollection->addJs('dt/js/editor.price.js');
        $this->assetsCollection->addJs('dt/js/dataTables.editor.min.js');
        $this->assetsCollection->addJs('assets/paginationjs/dist/pagination.min.js');
        $this->assetsCollection->addJs($this->config->module->path. '/views/ads/menu.js');
        $this->assetsCollection->addJs($this->config->module->path. '/views/ads/pagination.js');
        $this->assetsCollection->addCss('assets/paginationjs/dist/pagination.css');
        $this->assetsCollection->addJs($this->config->module->path. '/views/ads/ads.js');

        $this->assetsCollection->addInlineCss(/** @lang CSS */
            "
.DTE_Header {
display: none;
}
#serchbarfull{font-size: 1rem;}
#widget_prices_table{font-size: 1rem;}
");
    }
}