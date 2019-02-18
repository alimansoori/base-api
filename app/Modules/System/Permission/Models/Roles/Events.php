<?php
namespace Modules\System\Permission\Models\Roles;


use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRolesTranslate;

trait Events
{
    public function afterSaveTitle($data)
    {
        $titleModel = ModelRolesTranslate::findFirst([
            'conditions' => 'role_id=:menu_id: AND language_iso=:lang:',
            'bind' => [
                'menu_id' => $this->getId(),
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if (!$titleModel)
        {
            $titleModel = new ModelRolesTranslate();
        }

        if ($this->hasTransaction())
        {
            $titleModel->setTransaction($this->getTransaction());
        }

        if (isset($data['title']))
            $titleModel->setTitle($data['title']);

        $titleModel->setLanguageIso(ModelLanguage::getCurrentLanguage());
        $titleModel->setRoleId($this->getId());

        if (!$titleModel->save())
        {
            $rollbackMessage = [];
            foreach ($titleModel->getMessages() as $message)
            {
                $this->appendMessage($message);
                $rollbackMessage[] = $message->getMessage();
            }

            $this->getTransaction()->rollback(null, $titleModel);
        }
    }
}