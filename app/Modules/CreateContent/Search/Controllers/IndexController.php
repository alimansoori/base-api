<?php
namespace Modules\CreateContent\Search\Controllers;

use Lib\Common\Date;
use Lib\Common\Format;
use Lib\Mvc\Controllers\AdminController;
use Lib\Tables\Adapter\HierarchyTable;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Modules\CreateContent\Currency\Models\ModelCurrencyPrice;
use Modules\CreateContent\Currency\Tables\CategoryTable;
use Modules\CreateContent\Currency\Tables\CurrencyTable;
use Modules\CreateContent\Currency\Tables\PriceTable;

class IndexController extends AdminController
{
    protected function init()
    {
    }

}