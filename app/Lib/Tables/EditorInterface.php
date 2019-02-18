<?php
namespace Lib\Tables;

use Lib\Editors\Adapter as Editor;

interface EditorInterface
{
    public function initEditors(): void ;

    /**
     * @return Editor[]
     */
    public function getEditors(): array ;

    public function getEditor(string $name): Editor;

    public function addEditor(Editor $editor): void;

    public function hasEditor(string $name): bool;
}