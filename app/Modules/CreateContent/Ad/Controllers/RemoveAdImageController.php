<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Exception;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Currency\Models\ModelCurrency;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction;

class RemoveAdImageController extends ManageController
{
    public function indexAction()
    {
        $blobsToTmp = [];
        $response = [];
        try
        {
            if (!$this->request->getQuery('hierarchy_id'))
            {
                $response['data'] = [];
            }
            else
            {
                $adId = $this->request->getQuery('hierarchy_id');
                $data = $this->filterAndValidateData();

                /** @var Transaction $transaction */
                $transaction = $this->moduleTransaction->get();

                foreach ($data as $rowId => $datum)
                {
                    /** @var ModelAdImage $model */
                    $model = ModelAdImage::findFirst([
                        'conditions' => "id=:id: AND ad_id=:ad_id:",
                        'bind' => [
                            'id' => $rowId,
                            'ad_id' => $adId
                        ]
                    ]);

                    $model->setTransaction($transaction);

                    if (!$model->delete())
                    {
                        $transaction->rollback(null, $model);
                    }

                    $blobsToTmp[] = $model->getImageId();
                }

                $response['reload'] = true;

                $transaction->commit();

                foreach ($blobsToTmp as $blobId)
                {
                    /** @var ModelBlobs $blob */
                    $blob = ModelBlobs::findFirst($blobId);

                    if ($blob)
                    {
                        $blob->setStatus('tmp');
                        $blob->save();
                    }
                }
            }
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
        catch (\Phalcon\Mvc\Model\Exception $exception)
        {
            dump($exception->getMessage());
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

//        if (!$this->isValidName())
//        {
//            throw new Exception(T::_('access_denied'), 400);
//        }

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery('data');
    }

    private function isValidAction(): bool
    {
        if ($this->request->getQuery('action') == 'remove')
            return true;

        return false;
    }

    private function isValidName(): bool
    {
        if ($this->request->getQuery('name') == $this->tableCategory->process(false)->getEditor('category_editor')->getName())
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getQuery('data') && is_iterable($this->request->getQuery('data')))
            return true;

        return false;
    }
}