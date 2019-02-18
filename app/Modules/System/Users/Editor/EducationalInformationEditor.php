<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\EducationalInformation\TFields;
use Modules\System\Users\Models\ModelUserEducationalInformation;
use Modules\System\Users\Models\ModelUsers;

class EducationalInformationEditor extends Editor
{
    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldEducationalLevel();
        $this->fieldEducationalField();
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
            /** @var ModelUserEducationalInformation $educationalInfo */
            $educationalInfo = ModelUserEducationalInformation::findFirstByUserId($id);

            if(!$educationalInfo)
                continue;

            if(isset($data['educational_level']))
                $educationalInfo->setLevel($data['educational_level']);
            if(isset($data['educational_field']))
                $educationalInfo->setField($data['educational_field']);

            if(!$educationalInfo->save())
            {
                $this->appendMessages($educationalInfo->getMessages());
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