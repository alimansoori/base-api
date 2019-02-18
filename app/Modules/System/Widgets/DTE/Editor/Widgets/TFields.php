<?php
namespace Modules\System\Widgets\DTE\Editor\Widgets;


use Lib\DTE\Editor\Fields\Type\Radio;
use Lib\DTE\Editor\Fields\Type\Select;
use Lib\DTE\Editor\Fields\Type\Select2;
use Lib\DTE\Editor\Fields\Type\Text;
use Lib\Module\ModuleManager;
use Lib\Mvc\Model\WidgetPlaces\ModelWidgetPlaces;
use Lib\Translate\T;
use Phalcon\Validation\Validator\AlphaNumericValidator;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;

trait TFields
{
    protected function fieldWidget()
    {
        $widget = new Select('namespace');
        $widget->setLabel(T::_('widget'));
        $widget->setOptions(
            array_flip(ModuleManager::getWidgetsByNamespaceName())
        );

//        dump(array_keys(ModuleManager::getWidgetsByNamespaceName()));
        $widget->addValidator(
            new InclusionIn([
                'domain' => array_keys(ModuleManager::getWidgetsByNamespaceName()),
                'message' => ''
            ])
        );

        $this->addField($widget);
    }

    protected function fieldRoutes()
    {
        $routes = new Select2('route_name');
        $routes->setLabel(T::_('use_on_the_page'));
        $routes->setOptions($this->router->getRoutesByNameValue());
        $routes->setOptionsPair('name', 'value');

        $this->addField($routes);
    }

    protected function fieldPlace()
    {
        $place = new Select('place');
        $place->setOptions(ModelWidgetPlaces::getOptionsByLabelValue());
        $place->setPlaceholder(T::_('please_choose_one_of_the_following'));
        $place->setLabel(T::_('widget_place'));
        $place->addValidators([
            new PresenceOf([
                'message' => T::_('validator_presence_of')
            ]),
            new InclusionIn([
                'domain' => ModelWidgetPlaces::getDomainByValue(),
                'message' => T::_('validator_identical')
            ])
        ]);
        $this->addField($place);
    }

    protected function fieldPosition()
    {
        $position = new Text('position');
        $position->setLabel(T::_('widget_position'));
        $position->setFieldInfo(T::_('widget_field_info_position'));
        $position->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $position->addValidator(
            new Between([
                'minimum' => 1,
                'maximum' => 100,
                'message' => T::_('validator_between_min_max', ['MIN'=>1,'MAX'=>100])
            ])
        );

        $this->addField($position);
    }

    protected function fieldWidth()
    {
        $width = new Text('width');
        $width->setLabel(T::_('widget_width'));
        $width->setAttr([
            'placeholder' => T::_('widget_width_placeholder')
        ]);
        $width->setFieldInfo(T::_('widget_width_field_info'));
        $width->setFilters([
            'striptags'
        ]);

        $width->addValidator(
            new AlphaNumericValidator([
                'message' => T::_('validator_alpha_numeric')
            ])
        );

        $this->addField($width);
    }

    protected function fieldDisplay()
    {
        $display = new Radio('display');
        $display->setLabel(T::_('widget_display_label'));
        $display->setOptions([
            T::_('widget_display_inline') => 'inline',
            T::_('widget_display_block')  => 'block'
        ]);
        $display->setDef('block');

        $display->addValidator(
            new InclusionIn([
                'domain' => ['inline', 'block'],
                'message' => T::_('validator_identical')
            ])
        );

        $this->addField($display);
    }
}