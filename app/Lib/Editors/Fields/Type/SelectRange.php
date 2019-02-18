<?php
namespace Lib\Editors\Fields\Type;

class SelectRange extends Radio
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('select_range');
    }

    public function init()
    {
        parent::init();
        $this->getEditor()->assetsManager->addJs('dt/js/editor.select-range.js');
    }
}