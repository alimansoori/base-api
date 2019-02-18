<?php
namespace Lib\Editors\Fields\Type;


use Lib\Editors\Fields\Type\Radio\TRadioOptions;

class Radio extends Text
{
    use TRadioOptions;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('radio');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if(!empty($this->getOptions()))
            $output['options'] = $this->getOptions();
        if(!empty($this->getOptionsPair()))
            $output['optionsPair'] = $this->getOptionsPair();

        return $output;
    }
}