<?php
namespace Lib\DTE\Table\Buttons\Editor;


use Lib\DTE\Table\Button;

class ButtonEdit extends Button implements IEditor
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->extend = 'edit';
    }

    public function toArray()
    {
        $row = parent::toArray();

        if($this->getEditor()->getName())
            $row['editor'] = "||".$this->getEditor()->getName()."||";

        return $row;
    }
}