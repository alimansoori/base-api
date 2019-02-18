<?php
namespace Lib\DTE\Editor\Template;


class Fieldset extends FieldComposite
{
    public function render()
    {
        $output = parent::render();

        if(!$this->isVisible())
        {
            return "<fieldset id='{$this->getId()}' style='display: none;'><legend>{$this->title}</legend>$output</fieldset>";
        }
        return "<fieldset id='{$this->getId()}'><legend>{$this->title}</legend>$output</fieldset>";
    }
}