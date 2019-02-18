<?php
namespace Modules\CreateContent\Ad\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Lib\Validation;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdDetails;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategoryFields;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator\Regex;

class NewController extends AdminController
{
    public function initialize()
    {
        parent::initialize();

        $this->setTemplate('ui');
    }

    public function indexAction()
    {
        $this->assets->collection('head')->addJs('assets/jquery/dist/jquery.min.js');
        $this->assetsCollection->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsCollection->addCss('dt/css/editor.dataTables.min.css');
        $this->assetsCollection->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-select/js/dataTables.select.min.js');

        $this->assetsCollection->addJs('assets/select2/dist/js/select2.min.js');
        $this->assetsCollection->addCss('assets/select2/dist/css/select2.min.css');
        $this->assetsCollection->addJs('dt/js/editor.select2.js');
        $this->assetsCollection->addJs('dt/js/editor.select-range.js');
        $this->assetsCollection->addJs('dt/js/editor.range.js');
        $this->assetsCollection->addJs('dt/js/editor.price.js');
        $this->assetsCollection->addJs('dt/js/dataTables.editor.min.js');

        // menu category
        $this->assetsCollection->addJs($this->config->module->path. '/views/new/Babel_select_cat.js');

        $this->assetsCollection->addJs($this->config->module->path. '/views/new/new.js');

        $this->assetsCollection->addInlineCss('div.DTE{font-size:initial;}.DTE_Header{display:none;}');

//        $newEditor = new EditorAdNew('ad_new_editor');
//        $this->view->newEditor = $newEditor->process();
    }

    public function createAction()
    {
        $response = [];
        $postData = $this->request->getPost();

        try {
            if (!$this->validatePostData($postData))
            {
                throw new Exception(T::_('access_denied'));
            }
            $data = $postData['data'][0];

            $response = $this->validateData($data, $response);

            /** @var Transaction $transaction */
            $transaction = $this->moduleTransaction->get();

            $ad = new ModelAd();
            $ad->setTransaction($transaction);
            $ad->setTitle($data['title']);
            $ad->setDescription($data['description']);
            $ad->setCategoryId($data['category_id']);

            if (!$ad->save())
            {
                $transaction->rollback(null, $ad);
            }

            if (isset($data['files']) && is_array($data['files']))
            {
                foreach ($data['files'] as $image)
                {
                    $image = $image['id'];
                    /** @var ModelBlobs $findImage */
                    $findImage = ModelBlobs::findFirst($image);
                    if (!$findImage)
                    {
                        $transaction->rollback(T::_('access_denied'));
                    }

                    $modelAdImages = new ModelAdImage();
                    $modelAdImages->setTransaction($transaction);
                    $modelAdImages->setImageId($image);
                    $modelAdImages->setAdId($ad->getId());

                    if (!$modelAdImages->save())
                    {
                        $transaction->rollback(null, $modelAdImages);
                    }
                }
            }

            if (isset($response['fieldErrors']))
            {
                $transaction->rollback(T::_('access_denied'));
            }

            foreach ($data as $field=>$value)
            {
                if (!is_numeric($field))
                    continue;

                $adDetails = new ModelAdDetails();
                $adDetails->setTransaction($transaction);
                $adDetails->setAdId($ad->getId());
                $adDetails->setCategoryFieldId($field);
                $adDetails->setValue($value);

                if (!$adDetails->save())
                {
                    $transaction->rollback(null, $adDetails);
                }
            }

            $transaction->commit();

            if (isset($data['files']) && is_array($data['files']))
            {
                foreach ($data['files'] as $image)
                {
                    $image = $image['id'];
                    /** @var ModelBlobs $findImage */
                    $findImage = ModelBlobs::findFirst($image);
                    if (!$findImage)
                    {
                        continue;
                    }

                    $findImage->setStatus('active');
                    $findImage->update();
                }
            }

            $response['data'] = [
                'id' => $ad->getId()
            ];

        }
        catch (Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    if ($message->getField() == 'title' || $message->getField() == 'description')
                    {
                        $response['fieldErrors'][] = [
                            'name' => $message->getField(),
                            'status' => $message->getMessage()
                        ];
                    }
                    else
                    {
                        $response['error'] = $message->getMessage();
                    }
                }
            }
            elseif($exception->getMessage())
            {
                $response['error'] = $exception->getMessage();
            }
        }
        catch (Exception $exception) {
            $response['error'] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function validatePostData($postData)
    {
        if (
            !isset($postData['action']) ||
            $postData['action'] != 'create' ||
            !isset($postData['data']) ||
            !is_array($postData['data'])
        )
        {
            return false;
        }

        return true;
    }

    private function validateData(array $data, $response=[])
    {
        $validation = new Validation();

        foreach ($data as $field=>$value)
        {
            if (is_numeric($field))
            {
                /** @var ModelCategoryFields $fieldModel */
                $fieldModel = ModelCategoryFields::findFirst($field);

                if ($fieldModel)
                {
                    $validation->add(
                        "$field",
                        new Regex([
                            'pattern' => '/'. $fieldModel->getField()->getValidationPattern(). '/',
                            'message' => $fieldModel->getField()->getErrorMessage(),
                            'allowEmpty' => false
                        ])
                    );
                }
            }
        }

        /** @var Message $message */
        foreach ($validation->validate($data) as $message)
        {
            $response['fieldErrors'][] = [
                'name' => $message->getField(),
                'status' => $message->getMessage()
            ];
        }
        return $response;
    }
}