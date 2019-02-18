<?php
namespace Lib\DTE\Table;


use Lib\DTE\Table\Buttons\IButton;

trait TButtons
{
    /** @var Button[] $buttons */
    protected $buttons = [];

    abstract public function initButtons();

    public function getButtons()
    {
        return $this->buttons;
    }

    public function getButton($name)
    {
        if(!$this->hasButton($name))
            throw new TableException("Button for name $name does not exist");

        return $this->buttons[$name];
    }

    /**
     * Adds a button to the table
     *
     * @param Button|string $button
     * @return Button
     * @throws TableException
     */
    public function addButton($button)
    {
        if(!($button instanceof Button || is_string($button)))
            throw new TableException('please enter parameter instance of Button Or string name');

        if(is_string($button))
        {
            $btnName = $button;
            if($this->hasButton($btnName))
                throw new TableException("Already table $btnName is exist");

            $button = new Button($btnName);
        }

        $button->setTable($this);
        $button->init();
        $this->buttons[$button->getName()] = $button;

        return $button;
    }

    /**
     * Adds a group of columns
     *
     * @param IButton[] $buttons
     * @param bool $merge
     * @return TButtons
     */
    public function addButtons(array $buttons, $merge = true)
    {
        $currentButtons = $this->buttons;
        $mergeButtons = [];
        if($merge)
        {
            if(is_array($currentButtons))
            {
                $mergeButtons = array_merge($currentButtons, $buttons);
            }
        }
        else
        {
            $mergeButtons = $buttons;
        }

        $this->buttons = $mergeButtons;

        return $this;
    }

    public function hasButton($name)
    {
        return isset($this->buttons[$name]);
    }
}