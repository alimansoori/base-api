<?php
namespace Modules\CreateContent\Ad\Models;


/**
 * @method ModelFields getField()
 */
class ModelFieldOptions extends BaseModel
{
    private $id;
    private $field_id;
    private $label;
    private $value;
    private $position;

    protected function init()
    {
        $this->setSource('field_options');
    }

    protected function relations()
    {
        $this->belongsTo(
            'field_id',
            ModelFields::class,
            'id',
            [
                'alias' => 'Field',
                'foreignKey' => true
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFieldId()
    {
        return $this->field_id;
    }

    /**
     * @param mixed $field_id
     */
    public function setFieldId($field_id): void
    {
        $this->field_id = $field_id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }
}