<?php
namespace Modules\System\Users\Editor\EducationalInformation;


use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;

trait TFields
{
    protected function fieldEducationalLevel()
    {
        $field = new Radio('educational_level');
        $field->setLabel(T::_('educational_level'));
        $field->setOptions([
            [
                'label' => T::_('associate_degree'),
                'value' => 'associate'
            ],
            [
                'label' => T::_('bachelor_degree'),
                'value' => 'bachelor'
            ],
            [
                'label' => T::_('master_degree'),
                'value' => 'master'
            ],
            [
                'label' => T::_('doctorate_degree'),
                'value' => 'doctorate'
            ]
        ]);

        $this->addField($field);
    }

    protected function fieldEducationalField()
    {
        $field = new Text('educational_field');
        $field->setLabel(T::_('educational_field'));

        $this->addField($field);
    }
}