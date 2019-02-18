<?php
namespace Lib\DTE\Editor\Fields\Type;


use Lib\DTE\Editor\Fields\Field;
use Lib\DTE\Editor\Fields\Type\Text\TTextOptions;

class Text extends Field
{
    use TTextOptions;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('text');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if(!empty($this->getAttr()))
            $output['attr'] = $this->getAttr();

        return $output;
    }
}