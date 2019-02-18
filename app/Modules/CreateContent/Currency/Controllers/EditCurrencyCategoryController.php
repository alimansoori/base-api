<?php
namespace Modules\CreateContent\Currency\Controllers;

use Lib\Exception;
use Lib\Translate\T;
use Phalcon\Mvc\Model\Transaction\Failed;
use Modules\CreateContent\Currency\Models\ModelCurrencyCategory;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\ModelInterface;

class EditCurrencyCategoryController extends IndexController
{
    public function indexAction()
    {
        $model = null;
        $response = [];
        try
        {
            $data = $this->filterAndValidateData();

            /** @var Transaction $transaction */
            $transaction = $this->moduleTransaction->get();

            foreach ($data as $rowId => $datum)
            {
                /** @var ModelCurrencyCategory $model */
                $model = ModelCurrencyCategory::findFirst($rowId);

                if (!$model)
                {
                    throw new Exception('این دسته بندی وجود نداره که بخاد ویرایش بشه');
                }
                $model->setTransaction($transaction);


                $model->assign(
                    $datum,
                    null,
                    [
                        'position'
                    ]
                );

                if (!$model->save())
                {
                    $transaction->rollback(null, $model);
                }

                if (isset($datum['title']))
                    $model->makeTranslate($datum);

            }

            if ($model instanceof ModelInterface)
            {
                $model->sortByPosition([
                    'parent_id'
                ]);
            }

            $response['reload'] = true;

            $transaction->commit();
        }
        catch (Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    $response['fieldErrors'][] = [
                        'name' => $message->getField(),
                        'status' => $message->getMessage()
                    ];
                }
            }
            else
            {
                $response['error'] = $exception->getMessage();
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
        if (!$this->isValidAction())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidName())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getPut('data');
    }

    private function isValidAction(): bool
    {
        if ($this->request->getPut('action') == 'edit')
            return true;

        return false;
    }

    private function isValidName(): bool
    {
        if ($this->request->getPut('name') == $this->tableCategory->process(false)->getEditor('category_editor')->getName())
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getPut('data') && is_iterable($this->request->getPut('data')))
            return true;

        return false;
    }
}