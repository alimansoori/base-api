<?php
namespace Modules\CreateContent\Currency\Widgets;


use Lib\Exception;
use Lib\Mvc\Model\Options\ModelOptions;
use Lib\Widget\WidgetAbstract;
use Modules\CreateContent\Currency\Controllers\WidgetPricesController;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

class Prices extends WidgetAbstract
{
    public function initialize(ModelWidgetInstance $widgetInstance, $params = [])
    {
        $categoryId = 'widget_prices_table_category_id_'. $widgetInstance->getId();

        if (ModelOptions::getOption($categoryId) === false)
        {
            throw new Exception("please set manage id option for widget prices");
        }

        $pricesTable = WidgetPricesController::tablePrices();
        $pricesTable->ajax->addData('category_id', ModelOptions::getOption($categoryId));

        return [
            'prices_table' => $pricesTable->process(),
            'params' => $params,
        ];
    }

    public static function setting(ModelWidgetInstance $widgetInstance)
    {
        // TODO: Implement setting() method.
    }
}