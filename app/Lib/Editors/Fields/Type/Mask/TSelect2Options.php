<?php
namespace Lib\Editors\Fields\Type\Mask;


trait TSelect2Options
{
    /** @var string|null */
    protected $mask;
    /** @var string|null */
    protected $placeholder;
    protected $maskOptions;

    /**
     * @return string|null
     */
    public function getMask(): ?string
    {
        return $this->mask;
    }

    /**
     * @param string|null $mask
     */
    public function setMask(?string $mask): void
    {
        $this->mask = $mask;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param string|null $placeholder
     */
    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return mixed
     */
    public function getMaskOptions()
    {
        return $this->maskOptions;
    }

    /**
     * @param mixed $maskOptions
     */
    public function setMaskOptions($maskOptions): void
    {
        $this->maskOptions = $maskOptions;
    }
}