<?php

namespace Modules\System\PageManager\Models\WidgetInstance;

use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Phalcon\Di;

class ModelWidgetInstance extends Model
{
    use TModelPageWidgetMapProperties;
    use TModelPageWidgetMapRelations;
    use TModelPageWidgetMapValidations;
    use TModelPageWidgetMapEvents;

    public function init()
    {
        $this->setSource('widget_instance');
        $this->setDbRef(true);
    }

    /**
     * iterates in sorted array and updates their position with new value from i=1
     * @param array $widgetsForSortPosition
     * @return void
     */
    private function iterateAndSaveNewPosition($widgetsForSortPosition)
    {
        $i = 1;
        foreach($widgetsForSortPosition as $widgetForSortPosition)
        {
            /** @var self $widget */
            $widget = self::findFirst($widgetForSortPosition->id);

            $widget->setPosition($i);

            if(!$widget->update())
            {
                foreach($widget->getMessages() as $message)
                {
                    die(print_r($message->getMessage()));
                }
            }
            $i++;
        }
    }

    /**
     * finds rows in widgets database, whose place that match the specified value
     * @param $value
     * @return array
     */
    public static function findWidgetsByPlace($value)
    {
        $widgets = self::find(
            [
                'place = :place:',
                'bind' =>
                    [
                        'place' => $value,
                    ]
            ]
        );
        return $widgets->toArray();

    }

    public function getListWidgetsNamePlace()
    {
        $widgets = ModelWidgets::find(
            [
                'columns' => 'name,place'
            ]
        );
        if (!empty($widgets))
        {
            $array =[];

            foreach ($widgets as $widget)
            {
                $array[$widget->place][] = $widget->name;
            }

            return $array;
        }
        return null;

    }

    public static function getTableInformation(ModelWidgets $widget)
    {
        $row = [];

        foreach( $widget->widgetInstances as $widgetInstance )
        {
            $row[] = self::getForTable($widgetInstance);
        }

        return $row;
    }

    public static function getForTable(ModelWidgetInstance $widgetInstance)
    {
        return array_merge(
            $widgetInstance->toArray(),
            [
                'DT_RowId' => $widgetInstance->getId(),
                'title' => [
                    'display' => T::_($widgetInstance->getTitle()),
                    '_' => $widgetInstance->getTitle()
                ],
                'module_id' => [
                    'display' => T::_($widgetInstance->getWidget()->getModule()->getTitle()),
                    '_' => $widgetInstance->getWidget()->getModuleId()
                ],
                'widget_id' => [
                    'display' => T::_($widgetInstance->getWidget()->getName()),
                    '_' => $widgetInstance->getWidgetId()
                ],
                'created' => [
                    'display' => $widgetInstance->getCreated(),
                    '_'       => $widgetInstance->getCreated()
                ],
                'modified' => [
                    'display' => $widgetInstance->getModified(),
                    '_' => $widgetInstance->getModified()
                ],
                'preview_url'           => Di::getDefault()->getShared('url')->get([
                    'for' => 'widget_instance_params__'. ModelLanguage::getCurrentLanguage(),
                    'widget_instance_params' => $widgetInstance->getId()
                ]),
            ]
        );
    }
}