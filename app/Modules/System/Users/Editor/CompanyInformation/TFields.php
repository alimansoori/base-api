<?php
namespace Modules\System\Users\Editor\CompanyInformation;


use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;

trait TFields
{
    protected function fieldCompanyName()
    {
        $field = new Text('company_name');
        $field->setLabel(T::_('company_name'));

        $this->addField($field);
    }

    protected function fieldCompanyType()
    {
        $field = new Radio('company_type');
        $field->setLabel(T::_('company_type'));
        $field->setOptions([
            [
                'label' => T::_('company_type_private'),
                'value' => 'private'
            ],
            [
                'label' => T::_('company_type_legal'),
                'value' => 'legal'
            ]
        ]);

        $this->addField($field);
    }

    protected function fieldCompanyEconomicCode()
    {
        $field = new Text('company_economic_code');
        $field->setLabel(T::_('company_economic_code'));

        $this->addField($field);
    }

    protected function fieldCompanyRegisterCode()
    {
        $field = new Text('company_register_code');
        $field->setLabel(T::_('company_register_code'));

        $this->addField($field);
    }

    protected function fieldCompanyNationalCode()
    {
        $field = new Text('company_national_code');
        $field->setLabel(T::_('company_national_code'));

        $this->addField($field);
    }

    protected function fieldCompanyResponsibility()
    {
        $field = new Text('company_responsibility');
        $field->setLabel(T::_('company_responsibility'));

        $this->addField($field);
    }

    protected function fieldCompanyPersonnelCode()
    {
        $field = new Text('company_personnel_code');
        $field->setLabel(T::_('company_personnel_code'));

        $this->addField($field);
    }
}