<?php
namespace Modules\System\Menu\Models\AdminMenuCategory;


use Modules\System\Menu\Models\ModelAdminMenuCategoryTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Message;

trait Events
{
    public function afterSaveTitle($title)
    {
        $titleModel = ModelAdminMenuCategoryTranslate::findFirst([
            'conditions' => 'category_id=:cat_id: AND language_iso=:lang:',
            'bind' => [
                'cat_id' => $this->getId(),
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if (!$titleModel)
        {
            $titleModel = new ModelAdminMenuCategoryTranslate();
        }

        if ($this->hasTransaction())
        {
            $titleModel->setTransaction($this->getTransaction());
        }

        $titleModel->setTitle($title);
        $titleModel->setLanguageIso(ModelLanguage::getCurrentLanguage());
        $titleModel->setCategoryId($this->getId());

        if (!$titleModel->save())
        {
            $rollbackMessage = [];
            foreach ($titleModel->getMessages() as $message)
            {
                $rollbackMessage[] = $message->getMessage();
            }
            $this->getTransaction()->rollback(join(' -- ', $rollbackMessage));
        }
    }
}