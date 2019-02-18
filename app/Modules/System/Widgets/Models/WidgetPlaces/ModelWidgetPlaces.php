<?php

namespace Modules\System\Widgets\Models\WidgetPlaces;

use Lib\Mvc\Model;

class ModelWidgetPlaces extends Model
{
    use TModelWidgetPlacesProperties;
    use TModelWidgetPlacesRelations;
    use TModelWidgetPlacesValidations;
    use TModelWidgetPlacesEvents;
    use TModelWidgetPlacesDataStorage;
    use TModelWidgetPlacesCommon;

    protected function init()
    {
        $this->setSource('widget_places');
        $this->setDbRef(true);
    }

    /**
     * returns an array of name and value columns
     * @example
     * <code>
     * Array (
     *      [0] => Array (
     *          [name] => foo
     *          [value] => footer
     *      )
     * )
     * </code>
     * @return array
     */
    public function getArrayWidgetPlaces()
    {
        $widgetPlaces = self::find(
            [
                'columns' => 'id ,name , value',
                //                    'order' => 'name ASC'
            ]

        );
        if (!empty($widgetPlaces))
            return $widgetPlaces->toArray();

        return null;

    }

    /**
     * returns an array of [name] => [value]
     * @example
     * <code>
     * if($flip == false)
     * {
     *      [footer] => foo
     *      [header] => head
     *      [sidebar] => side
     * }
     *
     * if($flip == true)
     * {
     *       [foo] => footer
     *       [head] => header
     *       [side] => sidebar
     * }
     * </code>
     * @param bool $flip
     * @return array
     */
    public function getListWidgetPlacesNameValue($flip = false)
    {

        $widgetPlaces = self::find(
            [
                'columns' => 'id ,name , value',
            ]

        );
        if (!empty($widgetPlaces))
        {
            if ($flip)
                return array_column($widgetPlaces->toArray(),'name','value');

            return array_flip(array_column($widgetPlaces->toArray(),'name','value'));

        }
        return null;

        //        $std = new \stdClass();
        //        if (true)
        //        {
        //            $std->success = false;
        //            $message = new Message('db is empty','name');
        //            $std->messages = $message ;
        //            return $std;
        //        }
    }

}