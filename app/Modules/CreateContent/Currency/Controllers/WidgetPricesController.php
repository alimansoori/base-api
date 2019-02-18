<?php
namespace Modules\CreateContent\Currency\Controllers;


use Lib\Mvc\Controller;
use Lib\Mvc\Model\Options\ModelOptions;
use Lib\Tables\Adapter;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Modules\CreateContent\Currency\Models\ModelCurrencyCategory;
use Modules\CreateContent\Currency\Tables\WidgetPricesTable;
use Modules\System\Native\Models\Language\ModelLanguage;

class WidgetPricesController extends Controller
{
    public static function tablePrices(): Adapter
    {
        $pricesTable = new WidgetPricesTable('widget_prices_table');
        $pricesTable->assetsCollection->addInlineCss("#widget_prices_table{font-size:initial;}");

        return $pricesTable;
    }

    public function indexAction()
    {
        $categoryId = $this->request->getQuery('category_id');

        /** @var ModelCurrency[] $currencies */
        $currencies = ModelCurrency::find([
            'order' => 'category_id, position'
        ]);

        if (!$currencies)
        {
            return "Incorrect manage";
        }

        $row = [];
        foreach ($currencies as $currency)
        {
            $status = '';
            if ($currency->getPercentageChange()>0)
            {
                $status = 'high';
            }
            elseif ($currency->getPercentageChange() < 0)
            {
                $status = 'low';
            }
            $row[] = [
                'DT_RowId'      => $currency->getId(),
                'id'            => $currency->getId(),
                'category_name' => $currency->getCategory()->getTranslates([
                    'conditions' => 'language_iso=:lang:',
                    'bind' => [
                        'lang' => ModelLanguage::getCurrentLanguage()
                    ]
                ])->getFirst()->getTitle(),
                'title'         => $currency->getTitleTranslate(),
                'live_price'    => $currency->getLivePrice(),
                'percent'       => $currency->getPercentageChange(),
                'min'           => $currency->getMinMaxPrices(time())->min,
                'max'           => $currency->getMinMaxPrices(time())->max,
                'time'          => $currency->getTimeLivePrice() ? date('H:i:s', $currency->getTimeLivePrice()) : null,
                'status'        => $status,
            ];
        }
        echo json_encode([
            'data' => $row
        ]);

        die;
    }
}