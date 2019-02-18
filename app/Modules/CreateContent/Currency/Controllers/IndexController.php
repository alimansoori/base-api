<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Common\Date;
use Lib\Common\Format;
use Lib\Mvc\Controllers\AdminController;
use Lib\Tables\Adapter\HierarchyTable;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Modules\CreateContent\Currency\Models\ModelCurrencyPrice;
use Modules\CreateContent\Currency\Tables\CategoryTable;
use Modules\CreateContent\Currency\Tables\CurrencyTable;
use Modules\CreateContent\Currency\Tables\PriceTable;

class IndexController extends AdminController
{
    /** @var HierarchyTable */
    protected $tableCategory;
    /** @var HierarchyTable */
    protected $tableCurrency;
    /** @var HierarchyTable */
    protected $tablePrice;

    protected function init()
    {
        $this->tableCategory = new CategoryTable('category_table');
        $this->tableCurrency = new CurrencyTable('currency_table');
        $this->tablePrice    = new PriceTable('price_table');
        $this->tableCurrency->setParent($this->tableCategory);
        $this->tablePrice->setParent($this->tableCurrency);
    }

    public function indexAction()
    {
        $this->view->categoryTable = $this->tableCategory->process();
        $this->view->currencyTable = $this->tableCurrency->process();
        $this->view->priceTable    = $this->tablePrice->process();
    }

}