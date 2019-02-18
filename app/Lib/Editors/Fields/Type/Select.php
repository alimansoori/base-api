<?php
namespace Lib\Editors\Fields\Type;

use Lib\Editors\Fields\Type\Select\TSelectOptions;

class Select extends Radio
{
    use TSelectOptions;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('select');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if($this->isMultiple())
            $output['multiple'] = $this->isMultiple();
        if($this->getPlaceholder())
            $output['placeholder'] = $this->getPlaceholder();
        if(!$this->isPlaceholderDisabled())
            $output['placeholderDisabled'] = $this->isPlaceholderDisabled();
        if($this->placeholderValue)
            $output['placeholderValue'] = $this->placeholderValue;
        if($this->separator)
            $output['separator'] = $this->separator;

        return $output;
    }

}