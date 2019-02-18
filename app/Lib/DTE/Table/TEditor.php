<?php
namespace Lib\DTE\Table;


use Lib\DTE\Editor;

trait TEditor
{
    /** @var Editor[] $editor */
    protected $editors = [];

    /**
     * @return Editor[]
     */
    public function getEditors()
    {
        return $this->editors;
    }

    /**
     * @param $name
     * @return Editor
     * @throws TableException
     */
    public function getEditor($name)
    {
        if(!isset($this->editors[$name]))
            throw new TableException('There are no editors with this name');

        return $this->editors[$name];
    }

    /**
     * @param Editor $editor
     * @return TEditor
     */
    public function setEditor( Editor $editor )
    {
        $editor->setTable($this);
        $this->editors[$editor->getName()] = $editor;
        return $this;
    }

    /**
     * @param Editor $editor
     * @return TEditor
     */
    public function addEditor( Editor $editor )
    {
        $editor->setTable($this);
        $this->editors[$editor->getName()] = $editor;
        return $this;
    }

    /**
     * @param Editor[] $editors
     * @return TEditor
     * @throws TableException
     */
    public function setEditors( array $editors )
    {
        foreach($editors as $editor)
        {
            if(!$editors instanceof Editor)
                throw new TableException('This editor does not instance of Editor class');

            $editor->setTable($this);
            $this->editors[$editor->getName()] = $editor;
        }

        return $this;
    }

    /**
     * @param Editor[] $editors
     * @return TEditor
     * @throws TableException
     */
    public function addEditors( array $editors )
    {
        foreach($editors as $editor)
        {
            if(!$editors instanceof Editor)
                throw new TableException('This editor does not instance of Editor class');

            $editor->setTable($this);
            $this->editors[$editor->getName()] = $editor;
        }

        return $this;
    }
}