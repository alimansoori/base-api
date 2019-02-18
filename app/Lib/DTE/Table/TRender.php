<?php
namespace Lib\DTE\Table;


trait TRender
{
    public function render()
    {
        return "<table id='{$this->getName()}' class='stripe row-border order-column cell-border' style='width: 100%'></table>";
    }
}