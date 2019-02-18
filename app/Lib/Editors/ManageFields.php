<?php
namespace Lib\Editors;


use Lib\Editors\Fields\Field;
use Lib\Editors\Fields\Type\Text;
use Lib\Translate\T;

trait ManageFields
{
    /** @var Field[] */
    protected $fields = [];
    protected $fieldTypes = [];

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param Field[] $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function addField(Field $field): void
    {
        $field->setEditor($this);
        $this->fields[$field->getName()] = $field;
        $this->fieldTypes[$field->getType()] = $field->getType();
    }

    /**
     * @param string $name
     * @return Field
     * @throws Exception
     */
    public function getField(string $name): Field
    {
        if($this->hasField($name))
            return $this->fields[$name];

        throw new Exception("Field with NAME=" . $name . " is not part of the editor");
    }

    public function hasField(string $name): bool
    {
        /**
         * Checks if the field is in the editor
         */
        return (isset($this->fields[$name]) && $this->fields[$name] instanceof Field);
    }

    public function removeField(string $name): void
    {
        if($this->hasField($name))
            unset($this->fields[$name]);
    }

    protected function fieldPosition()
    {
        $field = new Text('position');
        $field->setLabel(T::_('position'));
        $field->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $this->addField($field);
    }
}