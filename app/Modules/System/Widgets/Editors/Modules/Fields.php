<?php
namespace Modules\System\Widgets\Editors\Modules;


use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\Fields\Type\Textarea;
use Lib\Module\ModuleManager;
use Lib\Translate\T;

trait Fields
{
    protected function fieldName()
    {
        $field = new Select2('name');
        $field->setLabel(T::_('name'));
        $field->setOptions(
            array_values(ModuleManager::getAllModules())
        );
        $field->setOptionsPair('name', 'name');
        $this->addField($field);
    }

    protected function fieldTitle()
    {
        $field = new Text('title');
        $field->setData('title._');
        $field->setLabel(T::_('title'));
        $this->addField($field);
    }

    protected function fieldDescription()
    {
        $field = new Text('description');
        $field->setData('description._');
        $field->setLabel(T::_('description'));
        $this->addField($field);
    }

    protected function fieldPosition()
    {
        $position = new Text('position');
        $position->setLabel(T::_('position'));
        $position->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $this->addField($position);
    }
}