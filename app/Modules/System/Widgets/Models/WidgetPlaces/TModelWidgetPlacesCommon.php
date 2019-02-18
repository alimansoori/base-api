<?php
namespace Modules\System\Widgets\Models\WidgetPlaces;


use Lib\Translate\T;

trait TModelWidgetPlacesCommon
{
    public static function getOptionsByLabelValue()
    {
        $widgets = self::find([
            'columns' => 'name as label, value',
            'order'   => 'value'
        ]);

        $row = [];
        foreach($widgets as $widget)
        {
            $row[] = [
                'label' => T::_($widget->label),
                'value' => $widget->value
            ];
        }

        return $row;
    }

    public static function getDomainByValue()
    {
        $widgets = self::find([
            'columns' => 'value',
            'order'   => 'value'
        ]);

        if(!empty($widgets->toArray()))
        {
            return array_column(
                $widgets->toArray(),
                'value'
            );
        }

        return [];
    }
}