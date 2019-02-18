<?php
namespace Lib\Editors\Fields;


interface IField
{
    /**
     * @return string
     */
    public function getClassName();
    /**
     * @param string $className
     */
    public function setClassName( $className );

    /**
     * @return mixed
     */
    public function getCompare();
    /**
     * @param mixed $compare
     */
    public function setCompare( $compare );
    /**
     * @return mixed
     */
    public function getData();
    /**
     * @param mixed $data
     */
    public function setData( $data );
    /**
     * @return mixed
     */
    public function getDef();
    /**
     * @param mixed $def
     */
    public function setDef( $def );
    /**
     * @return mixed
     */
    public function getEntityDecode();
    /**
     * @param mixed $entityDecode
     */
    public function setEntityDecode( $entityDecode );
    /**
     * @return mixed
     */
    public function getFieldInfo();

    /**
     * @param mixed $fieldInfo
     */
    public function setFieldInfo( $fieldInfo );

    /**
     * @return mixed
     */
    public function getId();
    /**
     * @param mixed $id
     */
    public function setId( $id );

    /**
     * @return mixed
     */
    public function getLabel();

    /**
     * @param mixed $label
     */
    public function setLabel( $label );

    /**
     * @return mixed
     */
    public function getLabelInfo();
    /**
     * @param mixed $labelInfo
     */
    public function setLabelInfo( $labelInfo );
    /**
     * @return mixed
     */
    public function getMessage();
    /**
     * @param mixed $message
     */
    public function setMessage( $message );
    /**
     * @return mixed
     */
    public function isMultiEditable();
    /**
     * @param mixed $multiEditable
     */
    public function setMultiEditable( $multiEditable );
    /**
     * @return mixed
     */
    public function getName();
    /**
     * @param mixed $name
     */
    public function setName( $name );

    /**
     * @return mixed
     */
    public function isSubmit();
    /**
     * @param mixed $submit
     */
    public function setSubmit( $submit );
    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param mixed $type
     */
    public function setType( $type );

    public function process();
    public function render();
}