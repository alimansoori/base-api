<?php
namespace Lib\DTE\Editor\Fields;


use Lib\DTE\BaseEditor;
use Lib\Messages\Messages;

abstract class Field implements IField
{
    use TFieldOptions;
    use TFieldValidators;
    use TFieldFilters;
    use TFieldMessages;

    /** @var BaseEditor */
    protected $editor;

    public function __construct($name)
    {
        $name = trim($name);

        if(!$name)
            throw new \InvalidArgumentException('Editor field name is required');

        $this->name = $name;
        $this->data = $name;

        $this->messages = new Messages();
    }

    public function process()
    {

    }

    public function toArray()
    {
        $output = [];
        if($this->className)
            $output['className'] = $this->className;
        if($this->compare)
            $output['compare'] = $this->compare;
        if($this->data)
            $output['data'] = $this->data;
        if($this->def)
            $output['def'] = $this->def;
        if(is_bool($this->entityDecode))
            $output['entityDecode'] = $this->entityDecode;
        if($this->fieldInfo)
            $output['fieldInfo'] = $this->fieldInfo;
        if($this->id)
            $output['id'] = $this->id;
        if($this->label)
            $output['label'] = $this->label;
        if($this->labelInfo)
            $output['labelInfo'] = $this->labelInfo;
        if($this->message)
            $output['message'] = $this->message;
        if(!$this->isMultiEditable())
            $output['multiEditable'] = $this->isMultiEditable();
        if($this->name)
            $output['name'] = $this->name;
        if(!$this->isSubmit())
            $output['submit'] = $this->isSubmit();
        if($this->type)
            $output['type'] = $this->type;

        return $output;
    }

    public function setEditor(BaseEditor $editor)
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @return BaseEditor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    public function init()
    {

    }

    public function render()
    {
        return "<editor-field name='{$this->getName()}'></editor-field>";
    }
}