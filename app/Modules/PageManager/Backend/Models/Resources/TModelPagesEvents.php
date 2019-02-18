<?php
namespace Modules\PageManager\Backend\Models\Resources;


use Modules\System\Native\Models\Language\ModelLanguage;

trait TModelPagesEvents
{
    public function beforeValidation()
    {
//        if(!$this->getSlug() && $this->getTitle())
//        {
//            $this->setSlug(str_replace(' ', '-', $this->getTitle()));
//        }

        if(!$this->getLanguageIso())
        {
            $this->setLanguageIso(ModelLanguage::getCurrentLanguage());
        }

        $this->setCreatorId(
            $this->getDI()->get('auth')->getUserId()
        );
    }

//    public function beforeSave()
//    {
//        parent::beforeSave();
//
//        if ($this->getSlug())
//            $this->findRoutesBySlug();
//    }

}