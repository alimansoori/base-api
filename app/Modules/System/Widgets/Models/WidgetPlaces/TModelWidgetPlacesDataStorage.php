<?php

namespace Modules\System\Widgets\Models\WidgetPlaces;

 trait TModelWidgetPlacesDataStorage
{
     /**
      * updates columns value from database, by inputted array
      * @param $id
      * @param $data
      * @example
      * <code>
      *   $widgetPlace = new ModelWidgetPlaces();
      *   $widgetPlace->updateMethod( 1 ,['name' => 'site footer', 'value' => 'footer']);
      * </code>
      * @return void
      */
     public function updateMethod($id,$data)
    {
        /** @var ModelWidgetPlaces $widgetPlace */
        $widgetPlace = self::findFirst($id);

        if (!$widgetPlace)
        {
            return;
        }
        foreach ($data as $key => $value)
        {
            $ucfirstKey = ucfirst($key);

            if (method_exists($widgetPlace,'set'.$ucfirstKey))
            {
                $methodName = 'set'.$ucfirstKey;

                $widgetPlace->$methodName($value);

            }
        }
        if (!$widgetPlace->update())
            var_dump($widgetPlace->getMessages());
        else
            var_dump('updated');

    }

}