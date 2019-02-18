<?php
namespace Modules\System\Users\Editor\LoginInformation;


use Lib\DTE\Editor\Fields\Type\Password;
use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;

trait TFields
{
    protected function fieldUsername()
    {
        $field = new Text('username');
        $field->setLabel(T::_('username'));
        $field->setFieldInfo(T::_('username_field_info'));
        $this->addField($field);
    }

    protected function fieldEmail()
    {
        $field = new Text('email');
        $field->setLabel(T::_('email'));
        $this->addField($field);
    }

    protected function fieldPassword()
    {
        $field = new Password('password');
        $field->setLabel(T::_('password'));
        $field->addValidators([
            new Confirmation([
                'with' => 'confirm_password'
            ])
        ]);
        $this->addField($field);
    }

    protected function fieldConfirmPassword()
    {
        $field = new Password('confirm_password');
        $field->setLabel(T::_('confirm_password'));
        $this->addField($field);
    }

    protected function fieldStatus()
    {
        $field = new Radio('status');
        $field->setLabel(T::_('status'));
        $field->setOptions([
            [
                'label' => T::_('active'),
                'value' => 'active'
            ],
            [
                'label' => T::_('inactive'),
                'value' => 'inactive'
            ]
        ]);
        $this->addField($field);
    }
}