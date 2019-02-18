<?php
namespace Modules\CreateContent\Ad\Models;

/**
 * @method ModelFields   getField()
 * @method ModelCategory getCategory()
 */
class ModelCategoryFields extends BaseModel
{
    private $id;
    private $category_id;
    private $field_id;
    private $position;

    protected function init()
    {
        $this->setSource('category_fields');
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

        $this->belongsTo(
            'category_id',
            ModelCategory::class,
            'id',
            [
                'alias' => 'Category',
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
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
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