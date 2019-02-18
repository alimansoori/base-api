<?php
namespace Lib\Editors\Fields\Type;


use Lib\Editors\Fields\Type\Checkbox\TCheckboxOptions;

class Checkbox extends Radio
{
    use TCheckboxOptions;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('checkbox');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if($this->separator)
            $output['separator'] = $this->separator;
        if($this->unselectedValue)
            $output['unselectedValue'] = $this->unselectedValue;

        return $output;
    }
}