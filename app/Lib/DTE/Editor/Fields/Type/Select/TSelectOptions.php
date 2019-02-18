<?php
namespace Lib\DTE\Editor\Fields\Type\Select;


trait TSelectOptions
{
    protected $multiple = false;
    protected $placeholder;
    protected $placeholderDisabled = true;
    protected $placeholderValue;
    protected $separator;

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     */
    public function setMultiple( $multiple )
    {
        $this->multiple = $multiple;
    }


    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     */
    public function setPlaceholder( $placeholder )
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return bool
     */
    public function isPlaceholderDisabled()
    {
        return $this->placeholderDisabled;
    }

    /**
     * @param bool $placeholderDisabled
     */
    public function setPlaceholderDisabled( $placeholderDisabled = true )
    {
        $this->placeholderDisabled = $placeholderDisabled;
    }

    /**
     * @return mixed
     */
    public function getPlaceholderValue()
    {
        return $this->placeholderValue;
    }

    /**
     * @param mixed $placeholderValue
     */
    public function setPlaceholderValue( $placeholderValue )
    {
        $this->placeholderValue = $placeholderValue;
    }

    /**
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param mixed $separator
     */
    public function setSeparator( $separator )
    {
        $this->separator = $separator;
    }

}