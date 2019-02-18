<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Exception;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Lib\Validation;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Modules\CreateContent\Currency\Models\ModelCurrencyPrice;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Validation\Message\Group;
use Phalcon\Validation\Validator\File;

class UploadImageController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        try
        {
            $hierarchyId = $this->request->getPost('hierarchy_id');

            if (!$hierarchyId && !is_numeric($hierarchyId))
            {
                throw new Exception('incorrect hierarchy id');
            }
            $adId = $hierarchyId;

            $data = $this->filterAndValidateData();

            if (!$_FILES['upload'])
            {
                throw new Exception('file does not exist');
            }

            $messages = $this->validateFile();

            if ($messages->count() > 0)
            {
                foreach ($messages as $message)
                {
                    $response['fieldErrors'][] = [
                        'name' => $data['uploadField'],
                        'status' => $message->getMessage()
                    ];
                }
                throw new Exception('in valid file');
            }

            /** @var Transaction $transaction */
            $transaction = $this->moduleTransaction->get();

            $file = $_FILES['upload'];

            $model = new ModelBlobs();
            $model->setTransaction($this->transactions);
            $model->setName($file['name']);
            $model->setFormat($file['type']);
            $model->setSize($file['size']);

            if (!$model->save())
            {
                $transaction->rollback(null, $model);
                $this->transactions->rollback(null, $model);
            }

            $saveFile = $this->isSaveFile($file, $model->getId());

            if (!$saveFile)
            {
                $response['fieldErrors'][] = [
                    'name' => $data['uploadField'],
                    'status' => 'file does not save'
                ];
                $transaction->rollback();
                $this->transactions->rollback();
            }

            $response['files']['files'][$model->getId()] = array_merge(
                $model->toArray(),
                [
                    'web_path' => $this->url->get("static/image/". $model->getId().'.'. strtolower(pathinfo($model->getName(), PATHINFO_EXTENSION)))
                ]
            );
            $response['upload']['id'] = $model->getId();

            $transaction->commit();
            $this->transactions->commit();
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

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getPost();
    }

    private function isValidAction(): bool
    {
        if ($this->request->getPost('action') == 'upload')
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getPost('uploadField') && is_string($this->request->getPost('uploadField')))
            return true;

        return false;
    }

    private function validateFile(): Group
    {
        $validation = new Validation();
        $validation->add(
            'upload',
            new File([
                'maxSize' => '200K',
                'allowedTypes' => [
                    "image/png",
                    "image/jpeg",
                ]
            ])
        );

        return $validation->validate($_FILES);
    }

    private function isSaveFile($file, int $newName)
    {
        $newName = $newName. '.'. strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $target_dir = 'tmp/';

        $target_file = $target_dir . $newName;
        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = true;
        } else {
            echo "File is not an image.";
            return false;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            return false;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == false) {
            return false;
            // echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
               // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                return true;
            } else {
                // echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }
}