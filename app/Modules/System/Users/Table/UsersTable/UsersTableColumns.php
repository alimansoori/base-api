<?php
namespace Modules\System\Users\Table\UsersTable;


use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;

trait UsersTableColumns
{
    protected function columnUsername()
    {
        $username = new Column('username');
//        $username->setEditable(true);
        $username->setTitle(T::_('username'));
        $username->setRenderEditPencil();
        $username->setClassName('dt-center login-col');
        $this->addColumn($username);
    }

    protected function columnEmail()
    {
        $email = new Column('email');
        $email->setTitle(T::_('email'));
        $email->setClassName('dt-center login-col');
        $email->setRenderEditPencil();
        $this->addColumn($email);
    }

    protected function columnCreated()
    {
        $created = new Column('created');
        $created->setTitle(T::_('registration_date'));
        $created->setClassName('dt-center');
        $this->addColumn($created);
    }

    protected function columnStatus()
    {
        $column = new Column('status');
        $column->setRender( /** @lang JavaScript */
            "
if ( type === 'display' && row.status == 'inactive' ) {
    return '<i title=\"غیرفعال\" class=\"fas fa-exclamation-circle\"></i>';
}else if(type === 'display' && row.status == 'active') {
    return '<i title=\"فعال\" class=\"far fa-check-circle\"></i>';
}
    return data;
");
        $column->setTitle(T::_('status'));
        $column->setClassName('dt-center login-col');
//        $column->setRenderEditPencil();
        $column->setEditFields('status');
        $this->addColumn($column);
    }

    protected function columnTimeZone()
    {
        $timeZone = new Column('setting_time_zone');
        $timeZone->setVisible(false);
        $timeZone->setTitle(T::_('time_zone'));
        $timeZone->setRenderEditPencil();
        $timeZone->setClassName('dt-center setting-col');
        $this->addColumn($timeZone);
    }

    protected function columnLanguage()
    {
        $language = new Column('setting_language');
        $language->setTitle(T::_('language_user'));
        $language->setVisible(false);
        $language->setRenderEditPencil();
        $language->setClassName('dt-center setting-col');
        $this->addColumn($language);
    }

    protected function columnCompanyName()
    {
        $companyName = new Column('company_name');
        $companyName->setTitle(T::_('company_name'));
        $companyName->setClassName('dt-center company-col');
        $companyName->setRenderEditPencil();
        $this->addColumn($companyName);
    }

    protected function columnCompanyType()
    {
        $companyType = new Column('company_type');
        $companyType->setTitle(T::_('company_type'));
        $companyType->setVisible(false);
        $companyType->setClassName('dt-center company-col');
        $companyType->setRenderEditPencil();
        $this->addColumn($companyType);
    }

    protected function columnCompanyEconomicCode()
    {
        $companyEconomicCode = new Column('company_economic_code');
        $companyEconomicCode->setTitle(T::_('company_economic_code'));
        $companyEconomicCode->setVisible(false);
        $companyEconomicCode->setClassName('dt-center company-col');
        $companyEconomicCode->setRenderEditPencil();
        $this->addColumn($companyEconomicCode);
    }

    protected function columnCompanyNationalCode()
    {
        $companyNationalCode = new Column('company_national_code');
        $companyNationalCode->setTitle(T::_('company_national_code'));
        $companyNationalCode->setVisible(false);
        $companyNationalCode->setClassName('dt-center company-col');
        $companyNationalCode->setRenderEditPencil();
        $this->addColumn($companyNationalCode);
    }

    protected function columnCompanyRegisterCode()
    {
        $companyRegisterCode = new Column('company_register_code');
        $companyRegisterCode->setVisible(false);
        $companyRegisterCode->setTitle(T::_('company_register_code'));
        $companyRegisterCode->setClassName('dt-center company-col');
        $companyRegisterCode->setRenderEditPencil();
        $this->addColumn($companyRegisterCode);
    }

    protected function columnCompanyResponsibility()
    {
        $companyResponsibility = new Column('company_responsibility');
        $companyResponsibility->setVisible(false);
        $companyResponsibility->setTitle(T::_('company_responsibility'));
        $companyResponsibility->setClassName('dt-center company-col');
        $companyResponsibility->setRenderEditPencil();
        $this->addColumn($companyResponsibility);
    }

    protected function columnCompanyPersonnelCode()
    {
        $companyPersonnelCode = new Column('company_personnel_code');
        $companyPersonnelCode->setVisible(false);
        $companyPersonnelCode->setTitle(T::_('company_personnel_code'));
        $companyPersonnelCode->setClassName('dt-center company-col');
        $companyPersonnelCode->setRenderEditPencil();
        $this->addColumn($companyPersonnelCode);
    }

    protected function columnFirstName()
    {
        $firstName = new Column('first_name');
        $firstName->setTitle(T::_('first_name'));
        $firstName->setClassName('dt-center personal-col');
        $firstName->setRenderEditPencil();
        $this->addColumn($firstName);
    }

    protected function columnLastName()
    {
        $lastName = new Column('last_name');
        $lastName->setTitle(T::_('last_name'));
        $lastName->setClassName('dt-center personal-col');
        $lastName->setRenderEditPencil();
        $this->addColumn($lastName);
    }

    protected function columnParentName()
    {
        $parentName = new Column('parent_name');
        $parentName->setVisible(false);
        $parentName->setTitle(T::_('parent_name'));
        $parentName->setClassName('dt-center personal-col');
        $parentName->setRenderEditPencil();
        $this->addColumn($parentName);
    }

    protected function columnIdNumber()
    {
        $idNumber = new Column('id_number');
        $idNumber->setVisible(false);
        $idNumber->setTitle(T::_('id_number'));
        $idNumber->setClassName('dt-center personal-col');
        $idNumber->setRenderEditPencil();
        $this->addColumn($idNumber);
    }

    protected function columnPlaceOfBirth()
    {
        $placeOfBirth = new Column('place_of_birth');
        $placeOfBirth->setVisible(false);
        $placeOfBirth->setTitle(T::_('place_of_birth'));
        $placeOfBirth->setClassName('dt-center personal-col');
        $placeOfBirth->setRenderEditPencil();
        $this->addColumn($placeOfBirth);
    }

    protected function columnGender()
    {
        $gender = new Column('gender');
        $gender->setVisible(false);
        $gender->setTitle(T::_('gender'));
        $gender->setClassName('dt-center personal-col');
        $gender->setRenderEditPencil();
        $this->addColumn($gender);
    }

    protected function columnDateOfBirth()
    {
        $dateOfBirth = new Column('date_of_birth');
        $dateOfBirth->setVisible(false);
        $dateOfBirth->setTitle(T::_('date_of_birth'));
        $dateOfBirth->setClassName('dt-center personal-col');
        $dateOfBirth->setRenderEditPencil();
        $this->addColumn($dateOfBirth);
    }

    protected function columnNationalCode()
    {
        $nationalCode = new Column('national_code');
        $nationalCode->setVisible(false);
        $nationalCode->setTitle(T::_('national_code'));
        $nationalCode->setClassName('dt-center personal-col');
        $nationalCode->setRenderEditPencil();
        $this->addColumn($nationalCode);
    }

    protected function columnMobile()
    {
        $mobile = new Column('mobile');
        $mobile->setVisible(false);
        $mobile->setTitle(T::_('mobile'));
        $mobile->setClassName('dt-center personal-col');
        $mobile->setRenderEditPencil();
        $this->addColumn($mobile);
    }

    protected function columnPhone()
    {
        $phone = new Column('phone');
        $phone->setVisible(false);
        $phone->setTitle(T::_('phone'));
        $phone->setClassName('dt-center personal-col');
        $phone->setRenderEditPencil();
        $this->addColumn($phone);
    }

    protected function columnFax()
    {
        $fax = new Column('fax');
        $fax->setVisible(false);
        $fax->setTitle(T::_('fax'));
        $fax->setClassName('dt-center personal-col');
        $fax->setRenderEditPencil();
        $this->addColumn($fax);
    }

    protected function columnState()
    {
        $state = new Column('state');
        $state->setVisible(false);
        $state->setTitle(T::_('state'));
        $state->setClassName('dt-center personal-col');
        $state->setRenderEditPencil();
        $this->addColumn($state);
    }

    protected function columnCity()
    {
        $city = new Column('city');
        $city->setVisible(false);
        $city->setTitle(T::_('city'));
        $city->setClassName('dt-center personal-col');
        $city->setRenderEditPencil();
        $this->addColumn($city);
    }

    protected function columnPostalCode()
    {
        $postalCode = new Column('postal_code');
        $postalCode->setVisible(false);
        $postalCode->setTitle(T::_('postal_code'));
        $postalCode->setClassName('dt-center personal-col');
        $postalCode->setRenderEditPencil();
        $this->addColumn($postalCode);
    }

    protected function columnAddress()
    {
        $address = new Column('address');
        $address->setVisible(false);
        $address->setTitle(T::_('address'));
        $address->setClassName('dt-center personal-col');
        $address->setRenderEditPencil();
        $this->addColumn($address);
    }

    protected function columnEducationalLevel()
    {
        $educationalLevel = new Column('educational_level');
        $educationalLevel->setVisible(false);
        $educationalLevel->setTitle(T::_('educational_level'));
        $educationalLevel->setClassName('dt-center educational-col');
        $educationalLevel->setRenderEditPencil();
        $this->addColumn($educationalLevel);
    }

    protected function columnEducationalField()
    {
        $educationalField = new Column('educational_field');
        $educationalField->setVisible(false);
        $educationalField->setTitle(T::_('educational_field'));
        $educationalField->setClassName('dt-center educational-col');
        $educationalField->setRenderEditPencil();
        $this->addColumn($educationalField);
    }

    protected function columnProfileUrl()
    {
        $profileUrl = new Column('profile_url');
        $profileUrl->setVisible(false);
        $profileUrl->setTitle(T::_('profile_url'));
        $profileUrl->setClassName('dt-center further-col');
        $profileUrl->setRenderEditPencil();
        $this->addColumn($profileUrl);
    }

    protected function columnBlogAddress()
    {
        $blogAddress = new Column('blog_address');
        $blogAddress->setVisible(false);
        $blogAddress->setTitle(T::_('blog_address'));
        $blogAddress->setClassName('dt-center further-col');
        $blogAddress->setRenderEditPencil();
        $this->addColumn($blogAddress);
    }

    protected function columnSignature()
    {
        $signature = new Column('signature');
        $signature->setVisible(false);
        $signature->setTitle(T::_('signature'));
        $signature->setClassName('dt-center further-col');
        $signature->setRenderEditPencil();
        $this->addColumn($signature);
    }

    protected function columnFavorites()
    {
        $favorites = new Column('favorites');
        $favorites->setVisible(false);
        $favorites->setTitle(T::_('favorites'));
        $favorites->setClassName('dt-center further-col');
        $favorites->setRenderEditPencil();
        $this->addColumn($favorites);
    }

    protected function columnAvatarAddress()
    {
        $avatarAddress = new Column('avatar_address');
        $avatarAddress->setVisible(false);
        $avatarAddress->setTitle(T::_('avatar_address'));
        $avatarAddress->setClassName('dt-center further-col');
        $avatarAddress->setRenderEditPencil();
        $this->addColumn($avatarAddress);
    }

    protected function columnDescription()
    {
        $description = new Column('description');
        $description->setVisible(false);
        $description->setTitle(T::_('description'));
        $description->setClassName('dt-center further-col');
        $description->setRenderEditPencil();
        $this->addColumn($description);
    }
}