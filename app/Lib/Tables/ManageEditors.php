<?php
namespace Lib\Tables;

use Lib\Editors\Adapter as Editor;
use Lib\Editors\Fields\Field;

trait ManageEditors
{
    /** @var Editor[] */
    protected $editors = [];

    public function getEditors(): array
    {
        return $this->editors;
    }

    public function getEditor(string $name): Editor
    {
        if (!$this->hasEditor($name))
            throw new Exception("Editor $name does not exist");

        return $this->editors[$name];
    }

    public function addEditor(Editor $editor): void
    {
        $editor->setTable($this);
        $this->editors[$editor->getName()] = $editor;
    }

    public function hasEditor(string $name): bool
    {
        return isset($this->editors[$name]);
    }

    public function hasField(string $name): bool
    {
        /** @var \Lib\Editors\Adapter $editor */
        foreach ($this->getEditors() as $editor)
        {
            /** @var Field $field */
            foreach ($editor->getFields() as $field)
            {
                if ($field->getName() == $name)
                    return true;
            }
        }
        return false;
    }
}