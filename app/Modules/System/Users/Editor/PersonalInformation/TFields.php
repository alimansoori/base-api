<?php
namespace Modules\System\Users\Editor\PersonalInformation;


use Lib\DTE\Editor\Fields\Type\Date;
use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\Fields\Type\Textarea;
use Lib\Translate\T;

trait TFields
{
    protected function fieldFirstName()
    {
        $field = new Text('first_name');
        $field->setLabel(T::_('first_name'));

        $this->addField($field);
    }

    protected function fieldLastNameName()
    {
        $field = new Text('last_name');
        $field->setLabel(T::_('last_name'));

        $this->addField($field);
    }

    protected function fieldParentName()
    {
        $field = new Text('parent_name');
        $field->setLabel(T::_('parent_name'));

        $this->addField($field);
    }

    protected function fieldIdNumber()
    {
        $field = new Text('id_number');
        $field->setLabel(T::_('id_number'));

        $this->addField($field);
    }

    protected function fieldPlaceOfBirth()
    {
        $field = new Text('place_of_birth');
        $field->setLabel(T::_('place_of_birth'));

        $this->addField($field);
    }

    protected function fieldGender()
    {
        $field = new Radio('gender');
        $field->setLabel(T::_('gender'));
        $field->setOptions([
            [
                'label' => T::_('male'),
                'value' => 'male'
            ],
            [
                'label' => T::_('female'),
                'value' => 'female'
            ]
        ]);

        $this->addField($field);
    }

    protected function fieldDateOfBirth()
    {
        $field = new Date('date_of_birth');
        $field->setLabel(T::_('date_of_birth'));

        $this->addField($field);
    }

    protected function fieldNationalCode()
    {
        $field = new Text('national_code');
        $field->setLabel(T::_('national_code'));

        $this->addField($field);
    }

    protected function fieldMobile()
    {
        $field = new Text('mobile');
        $field->setLabel(T::_('mobile'));

        $this->addField($field);
    }

    protected function fieldPhone()
    {
        $field = new Text('phone');
        $field->setLabel(T::_('phone'));

        $this->addField($field);
    }

    protected function fieldFax()
    {
        $field = new Text('fax');
        $field->setLabel(T::_('fax'));

        $this->addField($field);
    }

    protected function fieldState()
    {
        $field = new Text('state');
        $field->setLabel(T::_('state'));

        $this->addField($field);
    }

    protected function fieldCity()
    {
        $field = new Text('city');
        $field->setLabel(T::_('city'));

        $this->addField($field);
    }

    protected function fieldPostalCode()
    {
        $field = new Text('postal_code');
        $field->setLabel(T::_('postal_code'));

        $this->addField($field);
    }

    protected function fieldAddress()
    {
        $field = new Textarea('address');
        $field->setLabel(T::_('address'));

        $this->addField($field);
    }
}