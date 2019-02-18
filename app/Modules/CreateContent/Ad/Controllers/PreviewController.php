<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Common\Format;
use Lib\Mvc\Controller;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelFieldOptions;

class PreviewController extends Controller
{
    public function indexAction()
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

        $owner = 1;
        if ($editAd->getUserId() != $this->auth->getUserId())
        {
            $owner = 0;
        }

        $response = array_merge(
            $editAd->toArray(),
            [
                'owner'         => $owner,
                'back_url'      => $this->request->getHeader('REFERER') ? $this->request->getHeader('REFERER') : null,
                'breadcrumbs'   => $this->getBreadcrumb($editAd),
                'details'       => $this->getDetails($editAd),
                'images'        => $this->getImages($editAd),
                'created'       => $this->convertTimeToDisplay($editAd->getCreated())
            ]
        );

        $this->assets->collection('head')->addJs('assets/jquery/dist/jquery.min.js');
        $this->assetsCollection->addJs($this->config->module->path. '/views/preview/detail_adv.js');
        $this->view->detail_ad = $response;
        $this->view->show_page_content = false;
    }

    private function getBreadcrumb(ModelAd $ad)
    {
        $breadcrumbs[] = [
            'url' => $this->url->get('ads?category_id='. $ad->getCategoryId()),
            'title' => $ad->getCategory()->getTitle()
        ];

        foreach ($ad->getCategory()->getParentListComplateObject() as $breadcrumb)
        {
            $breadcrumbs[] = [
                'url' => $this->url->get('ads?category_id='. $breadcrumb->getId()),
                'title' => $breadcrumb->getTitle()
            ];
        }
        return array_reverse($breadcrumbs);
    }

    private function getDetails(ModelAd $ad)
    {
        $details = [];
        foreach ($ad->getDetails() as $detail)
        {
            /** @var ModelFieldOptions $value */
            $value = $detail->getAdCategoryField()->getField()->getOptions([
                'conditions' => 'value=:value:',
                'bind' => [
                    'value' => $detail->getValue()
                ]
            ])->getFirst();

            if ($value)
            {
                $details[$detail->getAdCategoryField()->getField()->getLabel()] = $value->getLabel();
            }
            else
            {
                $details[$detail->getAdCategoryField()->getField()->getLabel()] = $detail->getValue();
            }
        }
        return $details;
    }

    private function getImages(ModelAd $ad)
    {
        $images = [];
        foreach ($ad->getImages() as $image)
        {
            $images[$image->getImageId()] = [
                'web_path' => $this->url->get("static/image/". $image->getImageId())
            ];
        }
        return $images;
    }

    private function convertTimeToDisplay(?int $time)
    {
        $created = Format::ilya_when_to_html(
            $time,
            7
        );

        $display = '';
        if (isset($created['data']))
        {
            $display = $created['data'];
            if (isset($created['prefix']) && isset($created['suffix']))
            {
                $display = $created['prefix'] . $created['data']. $created['suffix'];
            }
        }

        return $display;
    }
}