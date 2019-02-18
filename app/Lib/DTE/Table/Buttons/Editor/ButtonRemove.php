<?php
namespace Lib\DTE\Table\Buttons\Editor;


use Lib\DTE\Table\Button;

class ButtonRemove extends Button implements IEditor
{
    public function __construct()
    {
        $this->name   = 'remove';
        $this->extend = 'remove';
    }

    public function toArray()
    {
        $row = parent::toArray();

        if($this->getEditor()->getName())
            $row['editor'] = "||".$this->getEditor()->getName()."||";

        return $row;
    }
}