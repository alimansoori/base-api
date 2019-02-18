<?php
namespace Modules\CreateContent\Currency\Models;


use Lib\Mvc\Model;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelCurrencyCategoryTranslate[] getTranslates()
 * @method ModelCurrency[]                  getCurrencies()
 * @method ModelCurrencyCategory[]          getChilds()
 * @method ModelCurrencyCategory            getParent()
 */
class ModelCurrencyCategory extends Model
{
    private $id;
    private $parent_id;
    private $position;
    private $created;
    private $modified;

    protected function init()
    {
        $this->setSource('currency_category');
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Relations
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelCurrency::class,
            'category_id',
            [
                'alias' => 'Currencies',
                'foreignKey' => [
                    'message' => 'This manage usage Prices model'
                ]
            ]
        );

        $this->hasMany(
            'id',
            self::class,
            'parent_id',
            [
                'alias' => 'Childs',
                'foreignKey' => [
                    'message' => 'This manage usage Prices manage model'
                ]
            ]
        );

        $this->hasMany(
            'id',
            ModelCurrencyCategoryTranslate::class,
            'category_id',
            [
                'alias' => 'Translates',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->belongsTo(
            'parent_id',
            self::class,
            'id',
            [
                'alias' => 'Parent',
                'foreignKey' => [
                    'allowNulls' => true
                ]
            ]
        );
    }

    public function makeTranslate(array $data = []): void
    {
        $model = ModelCurrencyCategoryTranslate::findFirst([
            'conditions' => 'category_id=:category_id: AND language_iso=:lang:',
            'bind' => [
                'category_id' => $this->getId(),
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if (!$model)
        {
            $model = new ModelCurrencyCategoryTranslate();
            $model->setLanguageIso(ModelLanguage::getCurrentLanguage());
            $model->setCategoryId($this->getId());
        }

        if ($this->hasTransaction())
        {
            $model->setTransaction($this->getTransaction());
        }

        $model->assign(
            $data,
            null,
            [
                'title',
                'description'
            ]
        );

        if (!$model->save())
        {
            foreach ($model->getMessages() as $message)
            {
                $this->appendMessage($message);
            }

            if ($model->hasTransaction())
                $model->getTransaction()->rollback(null, $model);
        }

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
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
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

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }
}