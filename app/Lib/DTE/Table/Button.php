<?php
namespace Lib\DTE\Table;


use Lib\Common\Strings;
use Lib\DTE\Editor;
use Lib\DTE\Table;
use Lib\DTE\Table\Buttons\IButton;
use Lib\Mvc\User\Component;

class Button extends Component
{
    use TButtonOptions;
    protected $table;
    protected $editor;
    /** @var Button */
    protected $parent;

    const TYPE_OPT_STRING = 1;
    const TYPE_OPT_FUNCTION = 2;

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function init()
    {
        $this->getTable()->assetsManager->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->getTable()->assetsManager->addJs('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
    }

    /**
     * Sets the parent Editor for button
     *
     * @param Editor $editor
     * @return $this
     */
    public function setEditor( $editor )
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Returns the parent Editor to the button
     *
     * @return Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Sets the parent Table for button
     *
     * @param Table $table
     * @return $this
     */
    public function setTable( $table )
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Returns the parent Table to the button
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return Button
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Button $parent
     */
    public function setParent( $parent )
    {
        $this->parent = $parent;
    }
}