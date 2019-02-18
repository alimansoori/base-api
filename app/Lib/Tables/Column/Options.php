<?php

namespace Lib\Tables\Column;

use Lib\Common\Strings;
use Lib\Exception;

trait Options
{
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
     * @return $this
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
     */
    public function setDefaultContent( $defaultContent )
    {
        $this->defaultContent = $defaultContent;
        return $this;
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
     */
    public function setSearchable( $searchable )
    {
        $this->searchable = $searchable;
        return $this;
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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
     * @return TColumnOptions
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