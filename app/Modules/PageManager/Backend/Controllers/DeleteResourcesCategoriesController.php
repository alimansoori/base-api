<?php

namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Phalcon\Mvc\Model\Transaction;

class DeleteResourcesCategoriesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        try {
            $data = $this->filterAndValidateData();

            /** @var Transaction $transaction */
            $transaction = $this->moduleTransaction->get();

            foreach ($data as $rowId => $datum) {
                if (!is_numeric($rowId)) {
                    throw new Exception(T::_('access_denied'), 401);
                }
                /** @var ModelCategoryResources $model */
                $model = ModelCategoryResources::findFirst($rowId);

                if ($model->getParentId())
                {
                    if ($model->getParent())
                    {
                        $response['search'] = [
                            'field' => 'parent_id',
                            'regex' => "^(0|".implode('|', $model->getParent()->getParentList()).")$"
                        ];
                    }
                }

                $model->setTransaction($transaction);

                if (!$model->delete()) {
                    $transaction->rollback(null, $model);
                }

                break;
            }

            $response[ 'reload' ] = true;

            $transaction->commit();
        } catch (Transaction\Failed $exception) {
            $this->response->setStatusCode(406);

            if ($exception->getRecord()) {
                foreach ($exception->getRecord()->getMessages() as $message) {
                    if ($message->getField() == 'title' || $message->getField() == 'description' || $message->getField() == 'position')
                    {
                        $response[ 'fieldErrors' ][] = [
                            'name'   => $message->getField(),
                            'status' => $message->getMessage()
                        ];
                    }
                    else
                    {
                        $response[ 'error' ] = $message->getMessage();
                    }
                }
            } else {
                $response[ 'error' ] = $exception->getMessage();
            }
        } catch (Exception $exception) {
            if ($exception->getCode()) {
                $this->response->setStatusCode($exception->getCode());
            }

            $response[ 'error' ] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidAction()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidData()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery('data');
    }

    private function isValidAction(): bool
    {
        if ($this->request->getQuery('action') == 'remove') {
            return true;
        }

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getQuery('data') && is_iterable($this->request->getQuery('data'))) {
            return true;
        }

        return false;
    }
}