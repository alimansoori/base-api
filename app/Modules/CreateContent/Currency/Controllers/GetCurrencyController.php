<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Exception;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Modules\CreateContent\Currency\Models\ModelCurrencyTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;

class GetCurrencyController extends IndexController
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
                $hierarchyId = $this->request->getQuery('hierarchy_id');

                $data = $this->filterAndValidateData();

                $builder = $this->modelsManager->createBuilder();
                $builder->columns([
                    'currency.id as DT_RowId',
                    'currency.id',
                    'currency.position',
                    'translate.language_iso',
                    'translate.title',
                    'translate.description',
                ]);
                $builder->addFrom(ModelCurrency::class, 'currency');
                $builder->where("category_id=:cat_id:", ['cat_id' => $hierarchyId]);
                $builder->leftJoin(
                    ModelCurrencyTranslate::class,
                    "translate.currency_id=currency.id",
                    'translate'
                );
                $builder->andWhere(
                    "language_iso=:lang:",
                    [
                        'lang' => ModelLanguage::getCurrentLanguage()
                    ]
                );
                $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

                $builder = $this->queryDataTable(
                    $data,
//                    $this->tableCurrency->process(false),
                    $builder,
                    [
                        'title',
                    ]
                );

                $response['recordsFiltered'] = count($builder->getQuery()->execute()->toArray());
                $response['data'] = $builder->getQuery()->execute()->toArray();
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