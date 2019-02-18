<?php
namespace Modules\System\Permission\Editors\RoleResources;


use Lib\DTE\Editor\Fields\Type\Checkbox;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;

trait Fields
{
    protected function fieldResId()
    {
        $field = new Text('id');
        $this->addField($field);
    }

    protected function fieldStatus()
    {
        $field = new Checkbox('status');
        $field->setLabel(T::_('status'));
        $field->setSeparator('|');
        $field->setOptions([
            [
                'label' => '',
                'value' => 1
            ]
        ]);
        $this->addField($field);
    }
}