<?php
namespace Lib\DTE\Table\Buttons;



use Lib\DTE\Editor;
use Lib\DTE\Table;

interface IButton
{
    public function init();
    public function setName(string $name);
    public function getName(): string;

    /**
     * Sets the parent Editor for button
     *
     * @param Editor $editor
     * @return $this
     */
    public function setEditor($editor);

    /**
     * Returns the parent Editor to the button
     *
     * @return Editor
     */
    public function getEditor();

    /**
     * Sets the parent Table for button
     *
     * @param Table $table
     * @return $this
     */
    public function setTable($table);

    /**
     * Returns the parent Table to the button
     *
     * @return Table
     */
    public function getTable();

    public function setAction($action);
    public function getAction();
    public function setClassName($className);
    public function getClassName();
    public function setExtend($extend);
    public function getExtend();
    public function setKey($key);
    public function getKey();
    public function setText($text);
    public function getText();

    public function toArray();

}