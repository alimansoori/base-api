<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\FurtherInformation\TFields;
use Modules\System\Users\Models\ModelUserFurtherInformation;
use Modules\System\Users\Models\ModelUsers;

class FurtherInformationEditor extends Editor
{
    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldProfileUrl();
        $this->fieldBlogAddress();
        $this->fieldSignature();
        $this->fieldFavorites();
        $this->fieldAvatarAddress();
        $this->fieldDescription();
    }

    public function editAction()
    {
        foreach($this->getDataAfterValidate() as $id => $data)
        {
            /** @var ModelUserFurtherInformation $furtherInfo */
            $furtherInfo = ModelUserFurtherInformation::findFirstByUserId($id);

            if(!$furtherInfo)
                continue;

            if(isset($data['profile_url']))
                $furtherInfo->setProfileUrl($data['profile_url']);
            if(isset($data['blog_address']))
                $furtherInfo->setBlogAddress($data['blog_address']);
            if(isset($data['signature']))
                $furtherInfo->setSignature($data['signature']);
            if(isset($data['favorites']))
                $furtherInfo->setFavorites($data['favorites']);
            if(isset($data['avatar_address']))
                $furtherInfo->setAvatarAddress($data['avatar_address']);
            if(isset($data['description']))
                $furtherInfo->setDescription($data['description']);

            if(!$furtherInfo->save())
            {
                $this->appendMessages($furtherInfo->getMessages());
            }

            /** @var ModelUsers $user */
            $user = ModelUsers::findFirst($id);

            $this->addData(ModelUsers::getUserForTable($user));
        }
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        // TODO: Implement createAction() method.
    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }
}