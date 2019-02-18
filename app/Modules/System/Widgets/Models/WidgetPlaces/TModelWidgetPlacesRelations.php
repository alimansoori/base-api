<?php

namespace Modules\System\Widgets\Models\WidgetPlaces;

use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;

/**
 * @method   ModelPageWidgetPlaceMap[]  getPageWidgetPlaceMaps()
 * @property ModelPageWidgetPlaceMap[]  pageWidgetPlaceMaps
 */
trait TModelWidgetPlacesRelations
{
    public function relations()
    {
        $this->hasMany(
            'id',
            ModelPageWidgetPlaceMap::class,
            'place_id',
            [
                'alias' => 'PageWidgetPlaceMaps',

                'foreignKey' => [
                    'allowNulls' => false,
                    'message' => 'The page widget place map cannot be deleted because other tables are using it',
                ]
            ]
        );
    }

}