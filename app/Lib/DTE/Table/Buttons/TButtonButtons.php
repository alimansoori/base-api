<?php
namespace Lib\DTE\Table\Buttons;


use Lib\DTE\Table\Button;
use Lib\DTE\Table\TableException;

trait TButtonButtons
{
    /** @var Button[] $buttons */
    protected $buttons = [];

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
//        if(!$button instanceof Button || !is_string($button))
//            throw new TableException('please enter parameter instance of Button Or string name');

        if(is_string($button))
        {
            $btnName = $button;
            if($this->hasButton($btnName))
                throw new TableException("Already table $btnName is exist");

            $button = new Button($btnName);
        }

        $button->setTable($this->getTable());
        $button->setParent($this);
        $button->init();

        $this->buttons[$button->getName()] = $button;

        return $button;
    }

    /**
     * Adds a group of columns
     *
     * @param Button[] $buttons
     * @param bool $merge
     * @return TButtonButtons
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