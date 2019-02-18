<?php
namespace Lib\Editors\Fields;


use Lib\Exception;

trait TFieldOptions
{
    protected $className;
    protected $compare;
    protected $data;
    protected $def;
    protected $entityDecode;
    protected $fieldInfo;
    protected $id;
    protected $label;
    protected $labelInfo;
    protected $message;
    protected $multiEditable = true;
    protected $name;
    protected $submit = true;
    protected $type;

    public function getClassName()
    {
        return $this->className;
    }

    public function setClassName( $className )
    {
        $this->className = $className;
        return $this;
    }

    public function getCompare()
    {
        return $this->compare;
    }

    public function setCompare( $compare )
    {
        $this->compare = $compare;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData( $data )
    {
        $this->data = $data;
        return $this;
    }

    public function getDef()
    {
        return $this->def;
    }

    public function setDef( $def )
    {
        $this->def = $def;
        return $this;
    }

    public function getEntityDecode()
    {
        return $this->entityDecode;
    }

    public function setEntityDecode( $entityDecode )
    {
        $this->entityDecode = $entityDecode;
        return $this;
    }

    public function getFieldInfo()
    {
        return $this->fieldInfo;
    }

    public function setFieldInfo( $fieldInfo )
    {
        $this->fieldInfo = $fieldInfo;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel( $label )
    {
        $this->label = $label;
        return $this;
    }

    public function getLabelInfo()
    {
        return $this->labelInfo;
    }

    public function setLabelInfo( $labelInfo )
    {
        $this->labelInfo = $labelInfo;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage( $message )
    {
        $this->message = $message;
        return $this;
    }

    public function isMultiEditable()
    {
        return $this->multiEditable;
    }

    public function setMultiEditable( $multiEditable = true )
    {
        if(!is_bool($multiEditable))
            throw new Exception('multiEditable option must be boolean');

        $this->multiEditable = $multiEditable;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }

    public function isSubmit()
    {
        return $this->submit;
    }

    public function setSubmit( $submit = true )
    {
        if(!is_bool($submit))
            throw new Exception('submit option must be boolean');
        $this->submit = $submit;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
        return $this;
    }
}