<?php
namespace Lib\DTE\Editor\Fields\Type;

use Lib\DTE\Editor\Fields\Type\Date\TDateOptions;

class Date extends Text
{
    use TDateOptions;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('date');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if(!empty($this->getAttr()))
            $output['attr'] = $this->getAttr();

        return $output;
    }
}