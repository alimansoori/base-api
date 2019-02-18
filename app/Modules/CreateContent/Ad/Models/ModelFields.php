<?php
namespace Modules\CreateContent\Ad\Models;


use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelType getType()
 * @method ModelFieldOptions[] getOptions()
 */
class ModelFields extends BaseModel
{
    private $id;
    private $label;
    private $type_name;
    private $validation_pattern;
    private $validation_pattern_search;
    private $field_info;
    private $def;
    private $def_search;
    private $class_name;
    private $compare;
    private $label_info;
    private $message;
    private $error_message;

    protected function init()
    {
        $this->setSource('field');
    }

    protected function relations()
    {
        $this->belongsTo(
            'type_name',
            ModelType::class,
            'name',
            [
                'alias' => 'Type',
                'foreignKey' => true
            ]
        );

        $this->hasMany(
            'id',
            ModelFieldOptions::class,
            'field_id',
            [
                'alias' => 'Options',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
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
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * @param mixed $type_name
     */
    public function setTypeName($type_name): void
    {
        $this->type_name = $type_name;
    }

    /**
     * @return mixed
     */
    public function getValidationPattern()
    {
        return $this->validation_pattern;
    }

    /**
     * @param mixed $validation_pattern
     */
    public function setValidationPattern($validation_pattern): void
    {
        $this->validation_pattern = $validation_pattern;
    }

    /**
     * @return mixed
     */
    public function getFieldInfo()
    {
        return $this->field_info;
    }

    /**
     * @param mixed $field_info
     */
    public function setFieldInfo($field_info): void
    {
        $this->field_info = $field_info;
    }

    /**
     * @return mixed
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * @param mixed $def
     */
    public function setDef($def): void
    {
        $this->def = $def;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * @param mixed $class_name
     */
    public function setClassName($class_name): void
    {
        $this->class_name = $class_name;
    }

    /**
     * @return mixed
     */
    public function getCompare()
    {
        return $this->compare;
    }

    /**
     * @param mixed $compare
     */
    public function setCompare($compare): void
    {
        $this->compare = $compare;
    }

    /**
     * @return mixed
     */
    public function getLabelInfo()
    {
        return $this->label_info;
    }

    /**
     * @param mixed $label_info
     */
    public function setLabelInfo($label_info): void
    {
        $this->label_info = $label_info;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     */
    public function setErrorMessage($error_message): void
    {
        $this->error_message = $error_message;
    }

    /**
     * @return mixed
     */
    public function getValidationPatternSearch()
    {
        return $this->validation_pattern_search;
    }

    /**
     * @param mixed $validation_pattern_search
     */
    public function setValidationPatternSearch($validation_pattern_search): void
    {
        $this->validation_pattern_search = $validation_pattern_search;
    }

    /**
     * @return mixed
     */
    public function getDefSearch()
    {
        return $this->def_search;
    }

    /**
     * @param mixed $def_search
     */
    public function setDefSearch($def_search): void
    {
        $this->def_search = $def_search;
    }
}