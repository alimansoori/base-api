<?php
namespace Modules\System\Widgets\Models\Modules;


use Modules\System\Widgets\Models\ModelModuleWidgetMap;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;

/**
 * @method ModelWidgets[]           getWidgets()
 * @method ModelModuleWidgetMap[]   getModuleWidgetMap()
 */
trait Relations
{
    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelModuleWidgetMap::class,
            'module_id',
            [
                'alias' => 'ModuleWidgetMap'
            ]
        );

        $this->hasManyToMany(
            'id',
            ModelModuleWidgetMap::class,
            'module_id','widget_id',
            ModelWidgets::class,
            'id',
            [
                'alias' => 'Widgets'
            ]
        );
    }
}