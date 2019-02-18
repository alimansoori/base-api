<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Lib\Mvc\Model\Transaction\Failed;
use Modules\CreateContent\Currency\Models\ModelCurrencyCategory;
use Modules\CreateContent\Currency\Models\ModelCurrencyCategoryTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction;
use function PHPSTORM_META\type;

class GetCurrencyCategoryController extends IndexController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'Please set title';

        try
        {
            $data = $this->filterAndValidateData();

            $builder = $this->modelsManager->createBuilder();
            $builder->columns([
                'manage.id as DT_RowId',
                'manage.id',
                'manage.position',
                'translate.title',
                'translate.description',
                'translate.language_iso',
            ]);
            $builder->addFrom(ModelCurrencyCategory::class, 'manage');
            $builder->leftJoin(
                ModelCurrencyCategoryTranslate::class,
                "translate.category_id=manage.id",
                "translate"
            );
            $builder->where("translate.language_iso=:lang:", ['lang' => ModelLanguage::getCurrentLanguage()]);

            $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

            $builder = $this->queryDataTable(
                $data,
//                $this->tableCategory->process(false),
                $builder,
                [
                    'title',
                    'position'
                ]
            );

            $response['recordsFiltered'] = count($builder->getQuery()->execute()->toArray());
            $response['data'] = $builder->getQuery()->execute()->toArray();
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