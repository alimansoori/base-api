<?php
namespace Modules\System\Users\Editor;


use Lib\DTE\Editor;
use Modules\System\Users\Editor\CompanyInformation\TFields;
use Modules\System\Users\Models\ModelUserCompanyInformation;
use Modules\System\Users\Models\ModelUsers;

class CompanyInformationEditor extends Editor
{
    use TFields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldCompanyName();
        $this->fieldCompanyType();
        $this->fieldCompanyEconomicCode();
        $this->fieldCompanyRegisterCode();
        $this->fieldCompanyNationalCode();
        $this->fieldCompanyResponsibility();
        $this->fieldCompanyPersonnelCode();
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
            /** @var ModelUserCompanyInformation $companyInfo */
            $companyInfo = ModelUserCompanyInformation::findFirstByUserId($id);

            if(!$companyInfo)
                continue;

            if(isset($data['company_name']))
                $companyInfo->setName($data['company_name']);
            if(isset($data['company_type']))
                $companyInfo->setType($data['company_type']);
            if(isset($data['company_economic_code']))
                $companyInfo->setEconomicCode($data['company_economic_code']);
            if(isset($data['company_national_code']))
                $companyInfo->setNationalCode($data['company_national_code']);
            if(isset($data['company_register_code']))
                $companyInfo->setRegisterCode($data['company_register_code']);
            if(isset($data['company_responsibility']))
                $companyInfo->setResponsibility($data['company_responsibility']);
            if(isset($data['company_personnel_code']))
                $companyInfo->setPersonnelCode($data['company_personnel_code']);

            if(!$companyInfo->save())
            {
                $this->appendMessages($companyInfo->getMessages());
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