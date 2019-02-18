<?php
namespace Modules\Users\Session\Forms;


use Lib\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class EditorForm extends Form
{
    public function initialize()
    {
//        $this->formInfo->title->set('Editor form title');

        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators([
            new PresenceOf([
                'message' => ':name is required'
            ])
        ]);
        $this->add($name);

        $desc = new Text('description');
        $desc->setLabel('Desc');
        $desc->addValidators([
            new PresenceOf([
                'message' => ':field is required'
            ])
        ]);
        $this->add($desc);
    }
}