<?php
namespace Modules\CreateContent\Currency\Models;


use Lib\Mvc\Model;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Validation\Validator\StringLength;

/**
 * @method ModelCurrencyCategory getCategory()
 * @method ModelLanguage         getLanguage()
 */
class ModelCurrencyCategoryTranslate extends Model
{
    private $id;
    private $category_id;
    private $language_iso;
    private $title;
    private $description;

    protected function init()
    {
        $this->setSource('currency_category_translate');
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Relations
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected function relations()
    {
        $this->belongsTo(
            'category_id',
            ModelCurrencyCategory::class,
            'id',
            [
                'alias' => 'Category',
                'foreignKey' => true
            ]
        );

        $this->belongsTo(
            'language_iso',
            ModelLanguage::class,
            'iso',
            [
                'alias' => 'Language',
                'foreignKey' => true
            ]
        );
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Validations
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected function mainValidation()
    {
        $this->validator->add(
            'title',
            new StringLength([
                'max' => 50
            ])
        );

        $this->validator->add(
            'description',
            new StringLength([
                'max' => 200,
                'allowEmpty' => true
            ])
        );
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Fields
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getLanguageIso()
    {
        return $this->language_iso;
    }

    /**
     * @param mixed $language_iso
     */
    public function setLanguageIso($language_iso): void
    {
        $this->language_iso = $language_iso;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }
}