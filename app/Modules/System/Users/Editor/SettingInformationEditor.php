<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\SettingInformation\TFields;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\Users\Models\ModelUserSettingInformation;

class SettingInformationEditor extends Editor
{
    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldTimeZone();
        $this->fieldLanguage();
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
            /** @var ModelUserSettingInformation $settingInfo */
            $settingInfo = ModelUserSettingInformation::findFirstByUserId($id);

            if(!$settingInfo)
                continue;

            if(isset($data['setting_time_zone']))
                $settingInfo->setTimeZone($data['setting_time_zone']);
            if(isset($data['setting_language']))
                $settingInfo->setLanguageIso($data['setting_language']);

            if(!$settingInfo->save())
            {
                $this->appendMessages($settingInfo->getMessages());
            }

            /** @var ModelUsers $user */
            $user = ModelUsers::findFirst($id);

            $this->addData(ModelUsers::getUserForTable($user));
        }
    }

    public function removeAction()
    {
        // TODO: Implement removeAction() method.
    }
}