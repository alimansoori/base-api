<?php
namespace Lib\Tables\Buttons\Editor;


use Lib\Editors\Adapter;
use Lib\Tables\Buttons\Button;
use Lib\Translate\T;

class ButtonCreate extends Button implements IEditor
{
    public function __construct($name=null, Adapter $editor = null)
    {
        $this->setText(T::_('create'));
        if (!$name)
        {
            $name = 'btn_create';
        }
        if ($editor)
        {
            $this->setEditor($editor);
        }
        parent::__construct($name);
        $this->extend = 'create';
    }

    public function toArray()
    {
        $row = parent::toArray();

        if($this->getEditor()->getName())
            $row['editor'] = "||".$this->getEditor()->getName()."||";

        return $row;
    }


}