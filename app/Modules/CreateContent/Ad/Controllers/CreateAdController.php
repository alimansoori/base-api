<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Exception;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\Model\Transaction\Failed;

class CreateAdController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        try
        {
            if (!$this->request->getPost('hierarchy_id'))
            {
                $response['data'] = [];
            }
            else
            {
                $categoryId = $this->request->getPost('hierarchy_id');

                $data = $this->filterAndValidateData();

                /** @var Transaction $transaction */
                $transaction = $this->moduleTransaction->get();

                /** @var ModelCurrency $model */
                $model = new ModelAd();
                $model->setTransaction($transaction);
                $model->setCategoryId($categoryId);

                $model->assign(
                    $data,
                    null,
                    [
                        'title',
                        'description',
                        'category_id'
                    ]
                );

                if (!$model->save())
                {
                    $transaction->rollback(null, $model);
                }

                $model->sortByPosition([
                    'category_id'
                ]);

                $response['reload'] = true;
                $transaction->commit();
            }
        }
        catch (Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    if ($this->tableAd->process(false)->hasField($message->getField()))
                    {
                        $response['fieldErrors'][] = [
                            'name' => $message->getField(),
                            'status' => $message->getMessage()
                        ];
                    }
                    else
                        $response['error']= $message->getMessage();

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

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        $data = $this->request->getPost('data');

        if (!is_array(reset($data)))
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return reset($data);
    }

    private function isValidAction(): bool
    {
        if ($this->request->getPost('action') == 'create')
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getPost('data') && is_iterable($this->request->getPost('data')))
            return true;

        return false;
    }
}