<?php
namespace Lib\DTE\Table\Select;

trait TSelectApi
{
    public function setSelectionFirstColumnOnly()
    {
        $this->setStyle(self::STYLE_OS);
        $this->setSelector('td:first-child');
        $this->setBlurable(true);
    }

    public function setSelectionAllButLastColumn()
    {
        $this->setStyle(self::STYLE_OS);
        $this->setSelector('td:not(:last-child)');
    }
}