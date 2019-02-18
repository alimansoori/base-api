<?php
namespace Lib\DTE\Table\Columns;

use Lib\DTE\Editor;
use Lib\DTE\Table;
use Lib\Exception;
use Lib\Mvc\User\Component;

class Column extends Component
{
    use TColumnOptions;

    /** @var Table $table */
    protected $table;
    /** @var Editor $editor */
    protected $editor;
    protected $target = 0;

    const RENDER_TYPE_FUNCTION = 'function';
    const RENDER_TYPE_STRING   = 'string';
    const RENDER_TYPE_OBJECT   = 'abject';
    const RENDER_TYPE_INT      = 'int';

    public function __construct($name)
    {
        $name = trim($name);

        if(empty($name) || !is_string($name))
            throw new Exception('Table column name is required');

        $this->name = $name;
        $this->data = $name;
    }

    public function init()
    {
    }

    /**
     * Sets the parent Table to the column
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
     * Returns the parent Table to the column
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param Editor $editor
     */
    public function setEditor( $editor )
    {
        $this->editor = $editor;
    }

    public function setOrdering($sortType)
    {
        $this->getTable()->assetsManager->addInlineJs( /** @lang JavaScript */
            "
{$this->table->getName()}.columns('{$this->getName()}:name').order('{$sortType}');
");
    }

    public function setRenderEditPencil()
    {
        $this->setRender( /** @lang JavaScript */
            "
if ( type === 'display' ) {
    return data + '&nbsp;&nbsp;&nbsp;<i class=\"fas fa-pencil-alt\"></i>';
}
return data;
");
    }

    /**
     * @return int
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param int $target
     */
    public function setTarget( $target )
    {
        $this->target = $target;
    }


    public function toArray()
    {
        $row = [];

        if($this->name)
            $row['name'] = $this->name;

        if($this->data)
        {
            $row['data'] = $this->data;
        }
        elseif($this->data === null)
        {
            $row['data'] = null;
        }

        if(!$this->isVisible())
            $row['visible'] = false;
        if($this->title)
            $row['title'] = $this->title;
        if($this->render)
            $row['render'] = $this->render;
        if($this->cellType)
            $row['cellType'] = $this->cellType;
        if(is_array($this->className) && !empty($this->className))
            $row['className'] = implode(' ', $this->className);
        if($this->width)
            $row['width'] = $this->width;
        if($this->contentPadding)
            $row['contentPadding'] = $this->contentPadding;
        if($this->createdCell)
            $row['createdCell'] = $this->createdCell;

        if($this->defaultContent)
            $row['defaultContent'] = $this->defaultContent;
        elseif($this->defaultContent === '')
            $row['defaultContent'] = '';

        if($this->type)
            $row['type'] = $this->type;
        if(!$this->isOrderable())
            $row['orderable'] = false;
        if(!$this->searchable)
            $row['searchable'] = $this->searchable;
        if(is_integer($this->orderData) || (is_array($this->orderData) && !empty($this->orderData)))
            $row['orderData'] = $this->orderData;
        if($this->orderDataType)
            $row['orderDataType'] = $this->orderDataType;
        if($this->orderSequence)
            $row['orderSequence'] = $this->orderSequence;

        return $row;
    }
}