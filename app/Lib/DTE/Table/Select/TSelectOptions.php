<?php
namespace Lib\DTE\Table\Select;

trait TSelectOptions
{
    /** @var boolean */
    protected $blurable = false;
    /** @var string */
    protected $className; // def => selected
    /** @var boolean */
    protected $info = true;
    /** @var string */
    protected $items; // def => row
    /** @var string */
    protected $selector;
    /** @var string */
    protected $style;

    /**
     * @return bool
     */
    public function isBlurable()
    {
        return $this->blurable;
    }

    /**
     * @param bool $blurable
     */
    public function setBlurable( $blurable )
    {
        $this->blurable = $blurable;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName( $className )
    {
        $this->className = $className;
    }

    /**
     * @return bool
     */
    public function isInfo()
    {
        return $this->info;
    }

    /**
     * @param bool $info
     */
    public function setInfo( $info )
    {
        $this->info = $info;
    }

    /**
     * @return string
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string $items
     */
    public function setItems( $items )
    {
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     */
    public function setSelector( $selector )
    {
        $this->selector = $selector;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle( $style )
    {
        $this->style = $style;
    }
}