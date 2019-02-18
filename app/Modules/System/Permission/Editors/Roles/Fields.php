<?php
namespace Modules\System\Permission\Editors\Roles;


use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\DTE\Editor\Fields\Type\Textarea;
use Modules\System\Widgets\Models\ModelModules;
use Lib\Translate\T;

trait Fields
{
    protected function fieldName()
    {
        $field = new Text('name');
        $field->setLabel(T::_('name'));
        $this->addField($field);
    }

    protected function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));
        $this->addField($field);
    }

    protected function fieldDescription()
    {
        $field = new Textarea('description');
        $field->setLabel(T::_('description'));
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
        $field->setDef('active');

        $this->addField($field);
    }

    protected function fieldRelatedModule()
    {
        $modules = ModelModules::find([
            'columns' => 'id, title'
        ]);
        $newModule = [];

        foreach($modules as $module)
        {
            $newModule[] = [
                'id' => $module->id,
                'title' => T::_($module->title)
            ];
        }

        $field = new Select2('module_id');
        $field->setLabel(T::_('related_module'));
        $field->setAttr([
            'style' => 'direction:ltr;'
        ]);
        $field->setOptions($newModule);
        $field->setOptionsPair('title', 'id');
        $this->addField($field);
    }
}