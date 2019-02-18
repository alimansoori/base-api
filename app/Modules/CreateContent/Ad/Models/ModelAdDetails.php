<?php
namespace Modules\CreateContent\Ad\Models;


use Phalcon\Validation\Validator\StringLength;

/**
 * @method ModelAd getAd()
 * @method ModelCategoryFields getAdCategoryField()
 */
class ModelAdDetails extends BaseModel
{
    private $id;
    private $ad_id;
    private $category_field_id;
    private $value;

    protected function init()
    {
        $this->setSource('ad_details');
    }

    protected function relations()
    {
        $this->belongsTo(
            'ad_id',
            ModelAd::class,
            'id',
            [
                'alias' => 'Ad',
                'foreignKey' => true
            ]
        );

        $this->belongsTo(
            'category_field_id',
            ModelCategoryFields::class,
            'id',
            [
                'alias' => 'AdCategoryField',
                'foreignKey' => true
            ]
        );
    }

    protected function mainValidation()
    {
        $this->validator->add(
            'value',
            new StringLength([
                'max' => 800,
                'allowEmpty' => true
            ])
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
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * @param mixed $ad_id
     */
    public function setAdId($ad_id): void
    {
        $this->ad_id = $ad_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryFieldId()
    {
        return $this->category_field_id;
    }

    /**
     * @param mixed $category_field_id
     */
    public function setCategoryFieldId($category_field_id): void
    {
        $this->category_field_id = $category_field_id;
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
}