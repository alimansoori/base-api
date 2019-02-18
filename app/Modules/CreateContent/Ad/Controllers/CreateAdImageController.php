<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Exception;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\Model\Transaction\Failed;

class CreateAdImageController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        try
        {
            $hierarchyId = $this->request->getPost('hierarchy_id');
            if (!$hierarchyId || !is_numeric($hierarchyId))
            {
                $response['data'] = [];
            }
            else
            {
                $adId = $this->request->getPost('hierarchy_id');

                $data = $this->filterAndValidateData();

                if (!$data['image_id'])
                {
                    $data['image_id'] = null;
                }

                /** @var Transaction $transaction */
                $transaction = $this->moduleTransaction->get();

                /** @var ModelAdImage $model */
                $model = new ModelAdImage();
                $model->setTransaction($transaction);
                $model->setAdId($adId);
                $model->setImageId($data['image_id']);

                $model->assign(
                    $data,
                    null,
                    [
                        'title',
                        'position',
                    ]
                );

                if (!$model->save())
                {
                    $transaction->rollback(null, $model);
                }

                $model->sortByPosition([
                    'ad_id',
                    'image_id',
                ]);

                $response['reload'] = true;
                $transaction->commit();

                /* @var ModelBlobs $blobImage */
                $blobImage = ModelBlobs::findFirst($data['image_id']);
                if ($blobImage)
                {
                    $blobImage->setStatus('active');
                    if (!$blobImage->update())
                    {
                        dump($blobImage->getMessages());
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
                    if ($this->tableAdImages->process(false)->hasField($message->getField()))
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