<?php
namespace Lib\Editors\Fields\Type\Radio;


trait TRadioOptions
{
    protected $options = [];
    protected $optionsPair = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions( $options )
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptionsPair()
    {
        return $this->optionsPair;
    }

    /**
     * @param string $label
     * @param string $value
     */
    public function setOptionsPair( $label = 'label', $value = 'value' )
    {
        $this->optionsPair['label'] = $label;
        $this->optionsPair['value'] = $value;
    }
}