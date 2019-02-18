<?php
namespace Modules\System\PageManager\Models\Pages;


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

    }

//    public function beforeSave()
//    {
//        parent::beforeSave();
//
//        if ($this->getSlug())
//            $this->findRoutesBySlug();
//    }

}