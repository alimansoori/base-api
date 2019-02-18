<?php
namespace Modules\System\PageManager\Editors\PageDesignForWidgetsEditor;


use Lib\DTE\Editor\Fields\Type\Select;
use Lib\Translate\T;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;

trait Fields
{
    protected function fieldPlaces()
    {
        $places = array_column(
            ModelWidgetPlaces::find()->toArray(),
            'name',
            'id'
        );

        $t_places = [];

        foreach ($places as $id=>$name)
        {
            $t_places[] = [
                'label' => T::_($name),
                'value' =>$id
            ];
        }

//        dump($t_places);

        $field = new Select('place');
        $field->setLabel(T::_('place'));
        $field->setOptions($t_places);

        $this->addField($field);
    }

    protected function fieldDevices()
    {
        $field = new Select('device');
        $field->setLabel(T::_('device'));
        $field->setOptions([
            [
                'label' => T::_('desktop'),
                'value' => 'desktop'
            ],
            [
                'label' => T::_('tablet'),
                'value' => 'tablet'
            ],
            [
                'label' => T::_('mobile'),
                'value' => 'mobile'
            ]
        ]);

        $this->addField($field);
    }
}