<?php
namespace Lib\Tables;

interface IColumn
{
    public function init();

    public function setTable( Adapter $table );

    /**
     * @return Adapter
     */
    public function getTable();

    public function getEditor();

    public function setEditor( $editor );

    public function setOrdering($sortType);

    public function setRenderEditPencil();

    public function getTarget();

    public function setTarget( $target );

    public function toArray();

    // Options

    public function setName( $name );
    public function getName();
    public function setData( $data );
    public function getData();
    public function setTitle( $title );
    public function getTitle();
    public function setVisible( $visible );
    public function isVisible();
    public function setRender( $render, $type );
    public function getRender();
    public function getCellType();
    public function setCellType( $cellType );
    public function getClassName();
    public function setClassName( $className );
    public function addClassName( $classname );
    public function getWidth();
    public function setWidth( $width );
    public function getContentPadding();
    public function setContentPadding( $contentPadding );
    public function getCreatedCell();
    public function setCreatedCell( $createdCell );
    public function getDefaultContent();
    public function setDefaultContent( $defaultContent );
    public function getType();
    public function setType( $type );
    public function isOrderable();
    public function setOrderable( $orderable );
    public function isSearchable();
    public function setSearchable( $searchable );
    public function getOrderData();
    public function setOrderData( $orderData );
    public function getOrderDataType();
    public function setOrderDataType( $orderDataType );
    public function getOrderSequence();
    public function setOrderSequence( $orderSequence );
    public function setEditable($editable = false);
    public function isEditable(): bool;
    public function getEditFields(): array;
    public function setEditFields( $editFields );
    public function addEditField($editField);
}