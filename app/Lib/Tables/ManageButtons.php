<?php
namespace Lib\Tables;


use Lib\Tables\Buttons\Button;

trait ManageButtons
{
    protected $buttons = [];

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getButton(string $key)
    {
        if(!$this->hasButton($key))
            throw new Exception("Button for name $key does not exist");

        return $this->buttons[$key];
    }
    public function addButton(Button $button)
    {
        $button->setTable($this);
        $this->buttons[$button->getName()] = $button;
    }

    //    public function addButtons(array $buttons, $merge = true);
    public function hasButton(string $key): bool
    {
        return isset($this->buttons[$key]);
    }
}