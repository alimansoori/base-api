<?php

namespace Modules\System\Widgets\Models\Widgets;

use Modules\System\Widgets\Models\ModelModules;
use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;

/**
 * @property ModelWidgetPlaces      $placeWidget
 * @property ModelWidgetInstance[]   widgetInstances
 * @method   ModelWidgetPlaces      getPlaceWidget()
 * @method   ModelWidgetInstance[]   getWidgetInstances()
 * @method   ModelModules           getModule()
 */
trait TModelWidgetsRelations
{
    public function relations()
    {
        $this->belongsTo(
            'module_id',
            ModelModules::class,
            'id',
            [
                'alias' => 'Module',
                'foreignKey' => [
                    'allowNulls' => false,
                    'message' => 'The module value does not exist on the ModelModule'
                ],
                'reusable' => true
            ]
        );

        $this->hasMany(
            'id',
            ModelWidgetInstance::class,
            'widget_id',
            [
                'alias' => 'WidgetInstances',
                'reusable' => true
            ]
        );
    }

}