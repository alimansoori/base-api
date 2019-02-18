<?php
/**
 * Created by PhpStorm.
 * User: Torab
 * Date: 01/07/2019
 * Time: 07:57 PM
 */

namespace Modules\System\Widgets\Forms;

use Lib\DTE\Editor\Forms\Fieldset;
use Lib\Forms\Element\Hidden;
use Lib\Forms\Element\Select;
use Lib\Forms\Element\Select2;
use Lib\Mvc\Model\WidgetPlaces\ModelWidgetPlaces;
use Lib\Translate\T;
use Lib\DTE\Editor\Form;
use Phalcon\Validation\Validator\Identical;

class WidgetForm extends Form
{
    public function initialize()
    {
        $nameGroupe = new Fieldset('name');
        $nameGroupe->setForm($this);
        $nameGroupe->setLabel('Name');
        $this->elmPlace($nameGroupe);
        $this->elmDisplay();
        $this->elmRoutes();
        $this->elmCsrf();

//        $this->add($nameGroupe);
    }

    private function elmPlace($nameGroupe)
    {
        $place = new Select('place');
        $place->setLabel(T::_('place'));
        $place->setOptions(
            array_column(
                ModelWidgetPlaces::find([
                    'columns' => 'name, value'
                ])->toArray(),
                'name',
                'value'
            )
        );
        $place->addValidator(
            new Identical([
                'domain' => array_column(
                    ModelWidgetPlaces::find([
                        'columns' => 'value',
                    ])->toArray(),
                    'value'
                ),
                'message' => ':field is not required'
            ])
        );

        $this->add($place);
    }

    private function elmDisplay()
    {
        $display = new Select('display');
        $display->setLabel(T::_('display'));
        $display->setOptions([
            'block' => 'Block',
            'inline' => 'Inline'
        ]);
        $display->addValidator(
            new Identical([
                'domain' => ['block', 'inline'],
                'message' => T::_('this_field_is_not_range', ['field' => ':field'])
            ])
        );

        $this->add($display);
    }

    private function elmRoutes()
    {
        $routes = new Select2('routes');
        $routes->setLabel(T::_('display'));
        $routes->setOptions([
            'block' => 'Block',
            'inline' => 'Inline'
        ]);

//        $this->add($routes);
    }

    private function elmCsrf()
    {
        $csrf = new Hidden('csrf', [
            'value' => $this->getCsrf()
        ]);
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => ':field validation failed'
        ]));

        $this->add($csrf);
    }

    public function getCsrf()
    {
        if(!$this->security->getSessionToken())
            return $this->security->getToken();
        else
            return $this->security->getSessionToken();
    }
}