<?php
namespace Modules\System\PageManager\Models\Routes;


use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\PageManager\Models\Pages\ModelPages;

trait TModelRoutesEvents
{
    public function beforeValidation()
    {
        if($this->getLanguageIso() == null)
        {
            $this->setLanguageIso(ModelLanguage::getCurrentLanguage());
        }

    }
    public function afterSave()
    {
        $this->saveStaticPageAfterCreateOrUpdate();
    }

    private function saveStaticPageAfterCreateOrUpdate()
    {
        if ($this->getType() == 'static')
        {
            $page = new ModelPages();
            if($this->isModeUpdate())
            {
                $page = ModelPages::findFirst([
                    'conditions' => 'route_id=?1',
                    'bind' => [
                        1 => $this->getId()
                    ]
                ]);
            }


            if($this->hasTransaction())
                $page->setTransaction($this->getTransaction());

            $page->setRouteId($this->getId());
            $page->setSlug($this->getPattern());
            $page->setTitle($this->getTitle());

            if(!$page->save())
            {
                dump($page->getMessages());
                if($page->hasTransaction())
                    $page->getTransaction()->rollback('rollback page does not save');

                foreach($page->getMessages() as $message)
                {
                    $this->appendMessage($message);
                }
            }
        }
    }
}