<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\ModelBlobs;
use Modules\CreateContent\Ad\Tables\TableAd;
use Modules\CreateContent\Ad\Tables\TableAdCategory;
use Modules\CreateContent\Ad\Tables\TableAdImages;

class ManageController extends AdminController
{
    /** @var TableAdCategory */
    protected $tableCategory;
    /** @var TableAd */
    protected $tableAd;
    /** @var TableAdImages */
    protected $tableAdImages;

    protected function init()
    {
        $this->tableCategory = new TableAdCategory('table_category');
        $this->tableAd = new TableAd('table_ad');
        $this->tableAdImages = new TableAdImages('table_ad_images');
        $this->tableAd->setParent($this->tableCategory);
        $this->tableAdImages->setParent($this->tableAd);
    }

    public function indexAction()
    {
        $this->view->tableCategory = $this->tableCategory->process();
        $this->view->tableAd = $this->tableAd->process();
        $this->view->tableAdImages = $this->tableAdImages->process();
    }
}