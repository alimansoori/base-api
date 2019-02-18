<?php
namespace Modules\System\Menu\Models\AdminMenu;


use Modules\System\Menu\Models\AdminMenuRoles\ModelAdminMenuRoles;
use Modules\System\Menu\Models\ModelAdminMenuTranslate;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Message;

trait Events
{
    public function beforeValidation()
    {
        parent::beforeValidation();

        if(!$this->getParentId())
            $this->setParentId(null);

        $this->setPositionIfEmpty();

        if ($this->getParentId())
        {
            /** @var ModelAdminMenu $findParent */
            $findParent = self::findFirst($this->getParentId());

            if ($findParent->getParentId())
            {
                $this->appendMessage(
                    new Message('One level access for parent', 'parent_id')
                );
                return false;
            }

            $this->setCategoryId($findParent->getCategoryId());
//            if ($findParent->getCategoryId() != $this->getCategoryId())
//            {
//                $this->appendMessage(
//                    new Message('manage does not match for parent', 'category_id')
//                );
//                return false;
//            }
        }
    }

    public function afterCreate()
    {
        parent::afterCreate();

//        $modelAdminMenuRoles = new ModelAdminMenuRoles();
//
//        if($this->getTransaction())
//            $modelAdminMenuRoles->setTransaction($this->getTransaction());
//
//        $modelAdminMenuRoles->setAdminMenuId($this->getId());
//        $modelAdminMenuRoles->setRoleId('admin');
//
//        if ($modelAdminMenuRoles->create() === false)
//        {
//            foreach($modelAdminMenuRoles->getMessages() as $message)
//                $this->appendMessage($message);
//
//            if($modelAdminMenuRoles->getTransaction())
//                $modelAdminMenuRoles->getTransaction()->rollback('Cannot save role menu');
//        }
    }

    public function afterSaveTitle($data)
    {
        $titleModel = ModelAdminMenuTranslate::findFirst([
            'conditions' => 'menu_id=:menu_id: AND language_iso=:lang:',
            'bind' => [
                'menu_id' => $this->getId(),
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if (!$titleModel)
        {
            $titleModel = new ModelAdminMenuTranslate();
        }

        if ($this->hasTransaction())
        {
            $titleModel->setTransaction($this->getTransaction());
        }

        if (isset($data['title']))
            $titleModel->setTitle($data['title']);

        $titleModel->setLanguageIso(ModelLanguage::getCurrentLanguage());
        $titleModel->setMenuId($this->getId());

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

    public function afterSaveRoles($data)
    {
        if (!isset($data['roles']))
            return false;

        if (!is_array($data['roles']))
            return false;

        foreach ($data['roles'] as $roleId)
        {
            if (!is_numeric($roleId))
                continue;

            $roleAdmin = ModelAdminMenuRoles::findFirst([
                'conditions' => 'role_id=:role_id: AND admin_menu_id=:admin_menu_id:',
                'bind' => [
                    'role_id' => $roleId,
                    'admin_menu_id' => $this->getId()
                ]
            ]);

            if (!$roleAdmin)
            {
                $roleAdmin = new ModelAdminMenuRoles();
                $roleAdmin->setRoleId($roleId);
                $roleAdmin->setAdminMenuId($this->getId());
            }

            if ($this->hasTransaction())
            {
                $roleAdmin->setTransaction($this->getTransaction());
            }

            if (!$roleAdmin->save())
            {
                $rollbackMessage = [];
                foreach ($roleAdmin->getMessages() as $message)
                {
                    $this->appendMessage($message);
                    $rollbackMessage[] = $message->getMessage();
                }
                $this->getTransaction()->rollback(null, $roleAdmin);
            }
        }
    }
}