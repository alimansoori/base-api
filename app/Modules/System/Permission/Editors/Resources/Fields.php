<?php
namespace Modules\System\Permission\Editors\Resources;



use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Translate\T;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Widgets\Models\ModelModules;

trait Fields
{
    protected function fieldTitle()
    {
        $field = new Text('title');
        $field->setLabel(T::_('title'));

        $this->addField($field);
    }

    protected function fieldModuleId()
    {
        $modules = ModelModules::find([
            'columns' => 'id, title'
        ]);

        $newModules = [];
        foreach($modules as $module)
        {
            $newModules[] = [
                'id' => $module->id,
                'title' => T::_($module->title)
            ];
        }

        $field = new Select2('module_id');
        $field->setData('module_id._');
        $field->setLabel(T::_('module'));
        $field->setOptions($newModules);
        $field->setOptionsPair('title', 'id');

        $this->addField($field);
    }

    protected function fieldRoles()
    {
        $roles = ModelRoles::find([
            'columns' => 'id, title'
        ]);

        $options = [];

        foreach ($roles as $role)
        {
            $options[] = [
                'label' => $role->title,
                'value' => $role->id
            ];
        }

        $field = new Select2('roles');
        $field->setData('roles');
        $field->setLabel(T::_('roles'));
        $field->setOptions($options);
        $field->setOpts([
            'placeholder' => T::_('please_select_roles'),
            'multiple' => true
        ]);

        $this->addField($field);
    }

    protected function fieldController()
    {
        $field = new Text('controller');
        $field->setLabel(T::_('controller'));

        $this->addField($field);
    }

    protected function fieldAction()
    {
        $field = new Text('action');
        $field->setLabel(T::_('action'));

        $this->addField($field);
    }
}