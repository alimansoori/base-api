<?php
namespace Modules\System\PageManager\Editors;


use Lib\DTE\Editor;
use Modules\System\PageManager\Editors\PageDesignForWidgetsEditor\Fields;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Mvc\Model\Transaction\Failed;

class PageDesignForWidgetsEditor extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldPlaces();
        $this->fieldDevices();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        // TODO: Implement createAction() method.
    }

    public function editAction()
    {
        try {
            foreach ($this->getDataAfterValidate() as $pageId=>$data)
            {
                $page = ModelPages::findFirst($pageId);

                if (!$page)
                {
                    $this->appendMessage('Page does not exist');
                    return false;
                }

                if (!$data['place'])
                {
                    $this->appendMessage('Place does not exist');
                    return false;
                }

                /** @var ModelWidgetPlaces $place */
                $place = ModelWidgetPlaces::findFirst($data[ 'place']);

                if (!$place)
                {
                    $this->appendMessage('Place does not exist');
                    return false;
                }

                $pagePlaceMap = ModelPageWidgetPlaceMap::findFirst([
                    'conditions' => 'page_id=:page_id: AND place_id=:place_id:',
                    'bind' => [
                        'page_id' => $pageId,
                        'place_id' => $place->getId()
                    ]
                ]);

                if (!$pagePlaceMap)
                {
                    $pagePlaceMap = new ModelPageWidgetPlaceMap();
                    $pagePlaceMap->setTransaction($this->transactions);
                    $pagePlaceMap->setPageId($pageId);
                    $pagePlaceMap->setPlaceId($place->getId());

                    if (!$pagePlaceMap->save())
                    {
                        $this->appendMessage('Error in save $pagePlaceMap');
                        return false;
                    }
                }

                $this->redirect = $this->url->get('dashboard/page-widgets/'. $data['device']. "/$pageId/{$data['place']}");


                break;
            }

            $this->transactions->commit();
        } catch (Failed $exception)
        {
            $this->appendMessage('page design editor rollback');
            return;
        }
    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }
}