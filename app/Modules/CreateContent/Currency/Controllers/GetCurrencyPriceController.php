<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Common\Format;
use Lib\Exception;
use Lib\Tables\Adapter;
use Lib\Translate\T;
use Modules\CreateContent\Currency\Models\ModelCurrencyPrice;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Transaction\Failed;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Modules\CreateContent\Currency\Models\ModelCurrencyTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Criteria;

class GetCurrencyPriceController extends IndexController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'Please set title';
        $response['recordsTotal'] = 0;
        $response['recordsFiltered'] = 0;

        try
        {
            if (!$this->request->getQuery('hierarchy_id'))
            {
                $response['data'] = [];
            }
            else
            {
                $currencyId = $this->request->getQuery('hierarchy_id');

                $data = $this->filterAndValidateData();

                $builder = $this->modelsManager->createBuilder();
                $builder->columns([
                    'price.id as DT_RowId',
                    'price.id',
                    'price.price',
                    'price.created',
                    'price.modified',
                ]);
                $builder->addFrom(ModelCurrencyPrice::class, 'price');

                $builder->where("price.currency_id=:currency_id:", ['currency_id' => $currencyId]);
                $builder->orderBy('created desc');
                $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

                $builder = $this->queryDataTable(
                    $data,
//                    $this->tablePrice->process(false),
                    $builder,
                    [
                        'price'
                    ]
                );

                $response['recordsFiltered'] = count($builder->getQuery()->execute()->toArray());
                $result = $builder->getQuery()->execute()->toArray();

                $row = [];
                foreach ($result as $res)
                {
                    $created = Format::ilya_when_to_html(
                        $res['created'],
                        7
                    );

                    $createdDisplay = '';
                    if (isset($created['data']))
                    {
                        $createdDisplay = $created['data'];
                        if (isset($created['prefix']) && isset($created['suffix']))
                        {
                            $createdDisplay = $created['prefix'] . $created['data']. $created['suffix'];
                        }
                    }

                    $modified = Format::ilya_when_to_html(
                        $res['created'],
                        7
                    );

                    $modifiedDisplay = '';
                    if (isset($modified['data']))
                    {
                        $modifiedDisplay = $modified['data'];
                        if (isset($modified['prefix']) && isset($modified['suffix']))
                        {
                            $modifiedDisplay = $modified['prefix'] . $modified['data']. $modified['suffix'];
                        }
                    }

                    $row[] = array_merge(
                        $res,
                        [
                            'created_at' => date('H:i:s', $res['created']),
                            'created' => [
                                'display' => $createdDisplay,
                                '_' => $res['created']
                            ],
                            'modified' => [
                                'display' => $modifiedDisplay,
                                '_' => $res['modified']
                            ],
                        ]
                    );
                }

                $response['data'] = $row;
            }
        }
        catch (Exception $exception)
        {
            if ($exception->getCode())
                $this->response->setStatusCode($exception->getCode());

            $response['error'] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidDraw())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidColumns())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery();
    }

    private function isValidDraw(): bool
    {
        if ($this->request->getQuery('draw') && is_numeric($this->request->getQuery('draw')))
            return true;

        return false;
    }

    private function isValidColumns(): bool
    {
        if ($this->request->getQuery('columns') && is_array($this->request->getQuery('columns')))
            return true;

        return false;
    }
}