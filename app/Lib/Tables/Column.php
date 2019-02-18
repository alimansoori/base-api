<?php
namespace Lib\Tables;

use Lib\Common\Strings;
use Lib\DTE\Editor;
use Lib\Exception;
use Lib\Mvc\User\Component;

class Column extends Component implements IColumn
{
    /** @var Adapter $table */
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

    /**
     * Sets the parent Table to the column
     *
     * @param Adapter $table
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
     * @return Adapter
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

    public function init()
    {
        // TODO: Implement init() method.
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Options
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected $name;
    protected $data;
    /** @var boolean */
    protected $visible = true;
    protected $render;
    /** @var string */
    protected $cellType;
    /** @var array */
    protected $className = [];
    /** @var string */
    protected $width;
    /** @var string */
    protected $contentPadding;
    /** @var string */
    protected $createdCell;
    /** @var string */
    protected $defaultContent;
    /** @var string */
    protected $title;
    /** @var string */
    protected $type;
    /** @var boolean */
    protected $editable = false;
    /** @var boolean */
    protected $orderable = true;
    /** @var boolean */
    protected $searchable = true;
    /** @var integer|array */
    protected $orderData;
    /** @var string */
    protected $orderDataType;
    /** @var array */
    protected $orderSequence; // ['asc', 'desc']
    protected $editFields = [];


    /**
     * Sets the column's name
     *
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * Returns the column's name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the column's data
     *
     * @param string $data
     * @return $this
     */
    public function setData( $data )
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Returns the column's data
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the column's label
     *
     * @param string $title
     * @return $this
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns the column's label
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the column's visible
     *
     * @param bool $visible
     * @return $this
     */
    public function setVisible( $visible )
    {
        if( is_bool( $visible ) )
            $this->visible = $visible;

        return $this;
    }

    /**
     * Returns the column's visible
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Sets the column's render
     *
     * @param string $render
     * @param $type
     * @return $this
     * @throws Exception
     */
    public function setRender( $render, $type=self::RENDER_TYPE_FUNCTION )
    {
        if($type == self::RENDER_TYPE_FUNCTION && is_string($render))
        {
            $render = Strings::multilineToSingleline( $render );
            $this->render = "||function(data, type, row, meta){{$render}}||";
        }
        elseif(($type == self::RENDER_TYPE_OBJECT && is_array($render)) || $type == self::RENDER_TYPE_STRING)
        {
            $this->render = $render;
        }
        elseif($type == self::RENDER_TYPE_INT)
        {
            $this->render = "||". $render. "||";
        }
        else
        {
            throw new Exception('column render exception');
        }

        return $this;
    }

    /**
     * Returns the column's render
     * @return string
     */
    public function getRender()
    {
        return $this->render;
    }

    /**
     * @return string
     */
    public function getCellType()
    {
        return $this->cellType;
    }

    /**
     * @param string $cellType
     * @return $this
     */
    public function setCellType( $cellType )
    {
        $this->cellType = $cellType;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     * @return $this
     */
    public function setClassName( $className )
    {
        $this->className = [$className];
        return $this;
    }

    public function addClassName( $classname )
    {
        $this->className[] = $classname;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $width
     * @return $this
     */
    public function setWidth( $width )
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentPadding()
    {
        return $this->contentPadding;
    }

    /**
     * @param string $contentPadding
     * @return $this
     */
    public function setContentPadding( $contentPadding )
    {
        $this->contentPadding = $contentPadding;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedCell()
    {
        return $this->createdCell;
    }

    /**
     * @param string $createdCell
     * @return $this
     */
    public function setCreatedCell( $createdCell )
    {
        $this->createdCell = $createdCell;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultContent()
    {
        return $this->defaultContent;
    }

    /**
     * @param string $defaultContent
     */
    public function setDefaultContent( $defaultContent )
    {
        $this->defaultContent = $defaultContent;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType( $type )
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOrderable()
    {
        return $this->orderable;
    }

    /**
     * @param bool $orderable
     * @return $this
     */
    public function setOrderable( $orderable )
    {
        $this->orderable = $orderable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * @param bool $searchable
     */
    public function setSearchable( $searchable )
    {
        $this->searchable = $searchable;
    }

    /**
     * @return array|int
     */
    public function getOrderData()
    {
        return $this->orderData;
    }

    /**
     * @param array|int $orderData
     * @return $this
     */
    public function setOrderData( $orderData )
    {
        $this->orderData = $orderData;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderDataType()
    {
        return $this->orderDataType;
    }

    /**
     * @param string $orderDataType
     * @return $this
     */
    public function setOrderDataType( $orderDataType )
    {
        $this->orderDataType = $orderDataType;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrderSequence()
    {
        return $this->orderSequence;
    }

    /**
     * @param array $orderSequence
     * @return $this
     */
    public function setOrderSequence( $orderSequence )
    {
        $this->orderSequence = $orderSequence;
        return $this;
    }

    public function setEditable($editable = false)
    {
        if($editable === true && !in_array('editable', $this->className))
        {
            $this->addClassName('editable');
            $this->editable = true;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @return array
     */
    public function getEditFields(): array
    {
        return $this->editFields;
    }

    /**
     * @param array|string $editFields
     * @return self
     */
    public function setEditFields( $editFields ): self
    {
        if(is_string($editFields))
            $this->editFields = [$editFields];
        elseif(is_array($editFields))
            $this->editFields = $editFields;

        return $this;
    }

    public function addEditField($editField): self
    {
        if(!is_string($editField))
            throw new Exception('param editField must be string');

        $this->editFields[] = $editField;

        return $this;
    }
}