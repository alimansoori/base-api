<?php
namespace Lib\Editors\Fields\Type\Checkbox;


trait TCheckboxOptions
{
    /** @var string|null */
    protected $separator = null;
    protected $unselectedValue;

    /**
     * @return mixed
     */
    public function getUnselectedValue()
    {
        return $this->unselectedValue;
    }

    /**
     * @param mixed $unselectedValue
     */
    public function setUnselectedValue( $unselectedValue )
    {
        $this->unselectedValue = $unselectedValue;
    }

    /**
     * @return string|null
     */
    public function getSeparator(): ?string
    {
        return $this->separator;
    }

    /**
     * @param string|null $separator
     */
    public function setSeparator( ?string $separator ): void
    {
        $this->separator = $separator;
    }

}