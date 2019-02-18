<?php
namespace Modules\Ad\FrontAdEdit\Controllers;


use Lib\Exception;
use Lib\Mvc\Controller;
use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\ModelBlobs;
use Lib\Translate\T;
use Lib\Validation;
use Modules\CreateContent\Ad\Editors\EditorAdNew;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdDetails;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Modules\CreateContent\Ad\Models\ModelCategoryFields;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator\Regex;

class EditController extends AdminController
{
    public function initialize()
    {
        parent::initialize();

        $this->setTemplate('ui');
    }

    public function editAction()
    {
        if (!$this->dispatcher->getParam('ad_id') && !is_numeric($this->dispatcher->getParam('ad_id')))
        {
            dump('access_denied');
        }

        $editId = $this->dispatcher->getParam('ad_id');
        /** @var ModelAd $editAd */
        $editAd = ModelAd::findFirst($editId);

        if (!$editAd)
        {
            dump('access denied');
        }

        if ($editAd && $editAd->getUserId() != $this->auth->getUserId())
        {
            dump('access denied');
        }

        $this->assets->collection('head')->addJs('assets/jquery/dist/jquery.min.js');
        $this->assetsCollection->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsCollection->addCss('dt/css/editor.dataTables.min.css');
        $this->assetsCollection->addJs($this->config->module->path. '/views/edit/edit.js');
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

        $this->assetsCollection->addInlineCss('div.DTE{font-size:initial;}.DTE_Header{display:none;}');

        $this->view->editAd = $editAd;
        //        $newEditor = new EditorAdNew('ad_new_editor', $editId);
//        $this->view->newEditor = $newEditor->process();
    }

    public function getAdEditAction()
    {
        $editId = $this->dispatcher->getParam('edit_id');

        if (!$editId || !is_numeric($editId))
        {
            dump('access denied');
        }

        if (!$this->auth->isLoggedIn())
        {
            dump('access denied');
        }

        /** @var ModelAd $editAd */
        $editAd = ModelAd::findFirst($editId);

        if (!$editAd)
        {
            dump('access denied');
        }

        if ($this->auth->getUserId() != $editAd->getUserId())
        {
            dump('access denied');
        }

        $files = [];

        /** @var ModelAdImage $image */
        foreach ($editAd->getImages() as $image)
        {
            $extention = pathinfo($image->getImage()->getName(), PATHINFO_EXTENSION);

            $files['files'][$image->getImageId()] = [
                'id' => $image->getImageId(),
                'web_path' => $this->url->get([
                    'for' => 'show_image__'. ModelLanguage::getCurrentLanguage(),
                    'image_id' => $image->getImageId(),
                    'type' => $extention
                ])
            ];
        }
        $this->response->setJsonContent([
            'data' => [
                array_merge(
                    $editAd->toArray(),
                    [
                        'DT_RowId' => "{$editAd->getId()}",
                        'files' => $editAd->getImages([
                            'columns' => 'image_id as id'
                        ])->toArray()
                    ]
                )
            ],
            'files' => $files
        ]);
        $this->response->send();
        die;
    }

    public function apiEditAction()
    {
        $editId = $this->dispatcher->getParam('ad_id');

        if (!$editId || !is_numeric($editId))
        {
            dump('access denied');
        }
        /** @var ModelAd $editAd */
        $editAd = ModelAd::findFirst($editId);

        if (!$editAd)
        {
            dump('access denied');
        }

        if ($this->auth->getUserId() != $editAd->getUserId())
        {
            dump('access denied');
        }

        $response = [];
        $postData = $this->request->getPost();

        try {
            if (!$this->validatePostData($postData))
            {
                throw new Exception(T::_('access_denied'));
            }
            $data = $postData['data'][$editId];

            $response = $this->validateData($data, $response);

            /** @var Transaction $transaction */
            $transaction = $this->moduleTransaction->get();

            $editAd->setTransaction($transaction);
            $editAd->setTitle($data['title']);
            $editAd->setDescription($data['description']);
//            $editAd->setCategoryId($data['category_id']);

            if (!$editAd->save())
            {
                $transaction->rollback(null, $editAd);
            }

            $imageFindAndDelete = [];

            if (isset($data['files']) && is_array($data['files']))
            {
                // delete already images
                $imageFindAndDelete = array_column(
                    $editAd->getImages()->toArray(),
                    'image_id', 'image_id'
                );

                foreach ($data['files'] as $image)
                {
                    $image = $image['id'];
                    /** @var ModelBlobs $findImage */
                    $findImage = ModelBlobs::findFirst($image);
                    if (!$findImage)
                    {
                        $transaction->rollback(T::_('access_denied'));
                    }

                    /** @var ModelAdImage $modelAdImages */
                    $modelAdImages = ModelAdImage::findFirst([
                        'conditions' => 'ad_id=:ad_id: AND image_id=:image_id:',
                        'bind' => [
                            'ad_id' => $editId,
                            'image_id' => $image
                        ]
                    ]);

                    if ($modelAdImages)
                    {
                        unset($imageFindAndDelete[$modelAdImages->getImageId()]);
                        continue;
                    }

                    $modelAdImages = new ModelAdImage();
                    $modelAdImages->setTransaction($transaction);
                    $modelAdImages->setImageId($image);
                    $modelAdImages->setAdId($editAd->getId());

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

            $categoryFieldsId = array_keys($editAd->getCategory()->getFieldsEditor());

            foreach ($data as $field=>$value)
            {
                if (!is_numeric($field))
                    continue;

                if (!in_array($field, $categoryFieldsId))
                {
                    continue;
                }

                $adDetails = $editAd->getDetails([
                    'conditions' => 'category_field_id=:c_id:',
                    'bind' => [
                        'c_id' => $field
                    ]
                ])->getFirst();

                if (!$adDetails)
                {
                    $adDetails = new ModelAdDetails();
                }
                //

                $adDetails->setTransaction($transaction);
                $adDetails->setAdId($editAd->getId());
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

            foreach ($imageFindAndDelete as $imageId)
            {
                /** @var ModelBlobs $blob */
                $blob = ModelBlobs::findFirst($imageId);
                $adImage = ModelAdImage::findFirst([
                    'conditions' => 'ad_id=:ad_id: AND image_id=:image_id:',
                    'bind' => [
                        'ad_id' => $editId,
                        'image_id' => $imageId
                    ]
                ]);

                if ($blob)
                {
                    $blob->setStatus('tmp');
                    if (!$blob->save())
                    {
                        dump($blob->getMessages());
                    }
                    $adImage->delete();
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
            $postData['action'] != 'edit' ||
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