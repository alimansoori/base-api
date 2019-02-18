<?php
namespace Lib\Tables\Buttons;


use Lib\DTE\Table\Button;

class Collection extends Button
{
    use TButtonButtons;

    protected $autoClose = false;
    protected $background = true;
    /** @var string */
    protected $backgroundClassName;

    public final function __construct($name)
    {
        parent::__construct($name);
        $this->extend = 'collection';
    }

    public function init()
    {
        parent::init();
    }

    public function toArray()
    {
        $out = parent::toArray();

        if($this->isAutoClose())
            $out['autoClose'] = true;

        if(!$this->isBackground())
            $out['background'] = false;

        if($this->backgroundClassName)
            $out['backgroundClassName'] = $this->backgroundClassName;

        if(!empty($this->getButtons()))
        {
            $buttons = [];
            /** @var Button $button */
            foreach($this->getButtons() as $button)
            {
                $buttons[] = $button->toArray();
            }

            $out['buttons'] = $buttons;
        }

        return $out;
    }

    /**
     * @return bool
     */
    public function isAutoClose(): bool
    {
        return $this->autoClose;
    }

    /**
     * @param bool $autoClose
     */
    public function setAutoClose( bool $autoClose ): void
    {
        $this->autoClose = $autoClose;
    }

    /**
     * @return bool
     */
    public function isBackground(): bool
    {
        return $this->background;
    }

    /**
     * @param bool $background
     */
    public function setBackground( bool $background ): void
    {
        $this->background = $background;
    }

    /**
     * @return string
     */
    public function getBackgroundClassName(): string
    {
        return $this->backgroundClassName;
    }

    /**
     * @param string $backgroundClassName
     */
    public function setBackgroundClassName( string $backgroundClassName ): void
    {
        $this->backgroundClassName = $backgroundClassName;
    }
}
