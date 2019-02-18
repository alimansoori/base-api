<?php
namespace Lib\DTE\Editor;


use Lib\DTE\Editor;

class Template extends Editor\Template\FieldComposite
{
    protected $editor;
    protected $visible = true;

    public function __construct(Editor $editor)
    {
        $this->editor = $editor;
        $this->id = 'template'. ucfirst($editor->getName());
    }

    public function render()
    {
        $out = parent::render();

        return "<div id='{$this->id}'>{$out}</div>";
    }

    /**
     * @return Editor
     */
    public function getEditor(): Editor
    {
        return $this->editor;
    }
}