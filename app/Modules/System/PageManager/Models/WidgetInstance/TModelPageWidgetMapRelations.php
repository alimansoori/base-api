<?php

namespace Modules\System\PageManager\Models\WidgetInstance;

use Modules\System\Widgets\Models\WidgetOptions\ModelWidgetOptions;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;

/**
 * @method   ModelWidgets         getWidget()
 */
trait TModelPageWidgetMapRelations
{
    public function relations()
    {
        $this->belongsTo(
            'widget_id',
            ModelWidgets::class,
            'id',
            [
                'alias' => 'Widget',
                'foreignKey' => [
                    'message' => 'The widget value does not exist on the Widgets model'
                ]
            ]
        );
    }

}