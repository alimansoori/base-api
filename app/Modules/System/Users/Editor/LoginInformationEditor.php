<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\LoginInformation\TFields;
use Modules\System\Users\Models\ModelUsers;

class LoginInformationEditor extends Editor
{

    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldUsername();
        $this->fieldEmail();
        $this->fieldPassword();
        $this->fieldConfirmPassword();
        $this->fieldStatus();
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
        foreach($this->getDataAfterValidate() as $id => $data)
        {
            /** @var ModelUsers $usersInfo */
            $usersInfo = ModelUsers::findFirst($id);

            if(!$usersInfo)
                continue;

            if(isset($data['username']))
                $usersInfo->setUsername($data['username']);
            if(isset($data['email']))
                $usersInfo->setEmail($data['email']);
            if(isset($data['password']))
                $usersInfo->setPassword($data['password']);
            if(isset($data['status']))
                $usersInfo->setStatus($data['status']);

            if(!$usersInfo->save())
            {
                $this->appendMessages($usersInfo->getMessages());
            }

            /** @var ModelUsers $user */
            $user = ModelUsers::findFirst($id);

            $this->addData(ModelUsers::getUserForTable($user));
        }
    }

    public function removeAction()
    {
    }
}