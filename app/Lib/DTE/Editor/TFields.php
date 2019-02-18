<?php
namespace Lib\DTE\Editor;

use Lib\DTE\Editor\Fields\Field;
use Lib\Exception;
use Lib\Filter;
use Lib\Messages\Messages;
use Lib\Translate\T;
use Lib\Validation;
use Phalcon\Text;
use Lib\DTE\Editor\Fields\Type\Text as TextField;

/**
 * @property Filter $filter
 * @method Messages getMessages()
 */
trait TFields
{
    /** @var Field[] */
    protected $fields = [];

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Field[] $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function addField(Field $field)
    {
        $field->setEditor($this);
        $this->fields[$field->getName()] = $field;
        $field->init();
        return $field;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function isValid($data = null)
    {
        if(empty($this->fields))
            return true;

        if(method_exists($this, 'beforeValidation'))
        {
            if($this->{'beforeValidation'}($data) === false)
                return false;
        }

        $validationStatus = true;

        $validation = new Validation();
        $this->setDataAfterValidate([]);

        foreach($this->getFields() as $field)
        {
            $validators = $field->getValidators();

            if(!is_array($validators) && count($validators) == 0)
                continue;

            if($this->operationMade == self::OP_CREATE)
            {
                foreach($validators as $validator)
                    $validation->add($field->getName(), $validator);
            }
            elseif($this->operationMade == self::OP_EDIT)
            {
                if(isset($data[$field->getName()]))
                {
                    foreach($validators as $validator)
                        $validation->add($field->getName(), $validator);
                }

            }
            if(is_array($field->getFilters()))
            {
                if(isset($data[$field->getName()]))
                    $this->addDataAfterValidate(
                        $field->getName(),
                        $this->filter->sanitize($data[$field->getName()], $field->getFilters())
                );
            }

            /**
             * Assign the filters to the validation
             */
            if(is_array($field->getFilters()))
                $validation->setFilters($field->getName(), $field->getFilters());
        }

        /**
         * Perform the validation
         */
        $messages = $validation->validate($data);

        if($messages->count())
        {
            foreach($messages as $message)
            {
                $this->getField($message->getField())->appendMessage($message);
            }

            $messages->rewind();
            $validationStatus = false;
        }

        if(!$validationStatus)
            $this->getMessages()->appendMessages($messages);

        if(method_exists($this, 'afterValidation'))
            $this->{'afterValidation'}($messages);

        /**
         * Return the validation status
         */
        return $validationStatus;
    }

    /**
     * @param string $name
     * @return Field
     * @throws Exception
     */
    public function getField($name)
    {
        if(isset($this->fields[$name]) && $this->fields[$name] instanceof Field)
            return $this->fields[$name];

        throw new Exception("Field with NAME=" . $name . " is not part of the editor");
    }

    public function hasField($name)
    {
        /**
         * Checks if the field is in the editor
         */
        return (isset($this->fields[$name]) && $this->fields[$name] instanceof Field);
    }

    public function removeField($name)
    {
        if(isset($this->fields[$name]))
            unset($this->fields[$name]);
    }

    protected function fieldPosition()
    {
        $field = new TextField('position');
        $field->setLabel(T::_('position'));
        $field->setAttr([
            'placeholder' => T::_('placeholder_numeric_field'),
            'type' => 'number'
        ]);

        $this->addField($field);
    }
}