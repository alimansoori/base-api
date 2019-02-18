<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\PersonalInformation\TFields;
use Modules\System\Users\Models\ModelUserPersonalInformation;
use Modules\System\Users\Models\ModelUsers;

class PersonalInformationEditor extends Editor
{
    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldFirstName();
        $this->fieldLastNameName();
        $this->fieldParentName();
        $this->fieldIdNumber();
        $this->fieldPlaceOfBirth();
        $this->fieldGender();
        $this->fieldDateOfBirth();
        $this->fieldNationalCode();
        $this->fieldMobile();
        $this->fieldPhone();
        $this->fieldFax();
        $this->fieldState();
        $this->fieldCity();
        $this->fieldPostalCode();
        $this->fieldAddress();
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
            /** @var ModelUserPersonalInformation $personalInfo */
            $personalInfo = ModelUserPersonalInformation::findFirstByUserId($id);

            if(!$personalInfo)
                continue;

            if(isset($data['first_name']))
                $personalInfo->setFirstName($data['first_name']);
            if(isset($data['last_name']))
                $personalInfo->setLastName($data['last_name']);
            if(isset($data['parent_name']))
                $personalInfo->setParentName($data['parent_name']);
            if(isset($data['id_number']))
                $personalInfo->setIdNumber($data['id_number']);
            if(isset($data['place_of_birth']))
                $personalInfo->setPlaceOfBirth($data['place_of_birth']);
            if(isset($data['gender']))
                $personalInfo->setGender($data['gender']);
            if(isset($data['date_of_birth']))
                $personalInfo->setDateOfBirth($data['date_of_birth']);
            if(isset($data['national_code']))
                $personalInfo->setNationalCode($data['national_code']);
            if(isset($data['mobile']))
                $personalInfo->setMobile($data['mobile']);
            if(isset($data['phone']))
                $personalInfo->setPhone($data['phone']);
            if(isset($data['fax']))
                $personalInfo->setFax($data['fax']);
            if(isset($data['state']))
                $personalInfo->setState($data['state']);
            if(isset($data['city']))
                $personalInfo->setCity($data['city']);
            if(isset($data['postal_code']))
                $personalInfo->setPostalCode($data['postal_code']);
            if(isset($data['address']))
                $personalInfo->setAddress($data['address']);

            if(!$personalInfo->save())
            {
                $this->appendMessages($personalInfo->getMessages());
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