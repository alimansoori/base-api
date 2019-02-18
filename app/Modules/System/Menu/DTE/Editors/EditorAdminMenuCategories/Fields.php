<?php
namespace Modules\System\Menu\DTE\Editors\EditorAdminMenuCategories;


use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;

trait Fields
{
    protected function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));

        $this->addField($field);
    }

    protected function fieldPosition()
    {
        $field = new Text('position');
        $field->setLabel(T::_('position'));
        $field->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $this->addField($field);
    }
}