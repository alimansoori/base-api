<?php
namespace Modules\System\Menu\Forms;


use Lib\Forms\Element\Hidden;
use Lib\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class FormAdminMenuRoles extends Form
{
    public function initialize()
    {
        $this->elmTitle();
        $this->elmPosition();
        $this->elmCsrf();

    }

    private function elmTitle()
    {
        $title = new Text('title');
        $title->setLabel('Title');
        $title->addValidators([
            new PresenceOf([
                'message' => ':field is required',
                'cancelOnFail' => true
            ]),
            new StringLength([
                'min' => 3,
                'max' => 20,
                'messageMinimum' => ':field is small',
                'messageMaximum' => ':field is big length'
            ])
        ]);

        $this->add($title);
    }

    private function elmPosition()
    {
        $position = new Text('position');
        $position->setLabel('Position');

        $position->addValidator(
            new Numericality([
                'message' => 'form => :field does not numeric',
                'allowEmpty' => true
            ])
        );

        $this->add($position);
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