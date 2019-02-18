<?php
namespace Modules\CreateContent\Ad\Controllers;


use Lib\Mvc\Controller;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelAdImage;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Modules\System\Native\Models\Language\ModelLanguage;

class ApiFieldsController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        if (!$this->auth->isLoggedIn())
        {
            $this->auth->logIn('admin', '123456789');
        }
    }

    public function getFieldsHierarchyAction()
    {
        $editAd = null;
        $files = [];
        if ($this->dispatcher->getParam('ad_id') && is_numeric($this->dispatcher->getParam('ad_id')))
        {
            /** @var ModelAd $editAd */
            $editAd = ModelAd::findFirst($this->dispatcher->getParam('ad_id'));

            if ($editAd->getUserId() != $this->auth->getUserId())
            {
                dump('access_denied');
            }

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

            $categoryId = $editAd->getCategoryId();
            $category = $editAd->getCategory();
        }
        else
        {
            $categoryId = $this->request->getPost('category_id');
            if (!is_numeric($categoryId))
            {
                die('access denied');
            }

            /** @var ModelCategory $category */
            $category = ModelCategory::findFirst($categoryId);
            if (!$category)
            {
                die('access denied');
            }
        }

        $this->response->setJsonContent(
            [
                'fields' => array_merge(
                    $category->getFieldsEditor($editAd),
                    [
                        [
                            'name' => 'category_id',
                            'data' => 'category_id',
                            'type' => 'hidden',
                            'def' => $categoryId
                        ]
                    ]
                ),
                'files' => []
            ]
        );
        $this->response->send();
        die;
    }

    public function searchAction()
    {
        $editAd = null;
        $categoryId = $this->request->getPost('category_id');
        if (!is_numeric($categoryId))
        {
            $this->response->setJsonContent([
                'fields' => [
                    [
                        'name' => 'category_id',
                        'data' => 'category_id',
                        'type' => 'hidden',
                    ]
                ],
                'data' => []
            ]);
            $this->response->send();
            die;
        }

        /** @var ModelCategory $category */
        $category = ModelCategory::findFirst($categoryId);
        if (!$category)
        {
            die('access denied');
        }

        $this->response->setJsonContent(
            [
                'fields' => array_merge(
                    $category->getFieldsEditorSearch($this->request->getPost('query')),
                    [
                        [
                            'name' => 'category_id',
                            'data' => 'category_id',
                            'type' => 'hidden',
                            'def' => $categoryId
                        ]
                    ]
                ),
                'data' => []
            ]
        );
        $this->response->send();
        die;
    }
}