<?php
namespace Modules\CreateContent\Currency\Models;


use Lib\Common\Date;
use Lib\Mvc\Model;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelCurrencyPrice[]     getPrices()
 * @method ModelCurrencyTranslate[] getTranslates()
 * @method ModelCurrencyCategory    getCategory()
 */
class ModelCurrency extends Model
{
    private $id;
    private $category_id;
    private $position;
    private $created;
    private $modified;

    protected function init()
    {
        $this->setSource('currency');
    }

    public function makeTranslate(array $data = []): void
    {
        $model = ModelCurrencyTranslate::findFirst([
            'conditions' => 'currency_id=:currency_id: AND language_iso=:lang:',
            'bind' => [
                'currency_id' => $this->getId(),
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        if (!$model)
        {
            $model = new ModelCurrencyTranslate();
            $model->setLanguageIso(ModelLanguage::getCurrentLanguage());
            $model->setCurrencyId($this->getId());
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

    public function getMinMaxPrices(string $timestamp)
    {
        return $this->getPrices([
            'columns' => 'MAX(price) AS max, MIN(price) AS min',
            'conditions' => "created BETWEEN :start: AND :end:",
            'bind' => [
                'start' => Date::getBeginOfDay($timestamp),
                'end'   => Date::getEndOfDay($timestamp),
            ]
        ])->getFirst();
    }

    public function getTitleTranslate()
    {
        $translate = $this->getTranslates([
            'conditions' => 'language_iso=:lang:',
            'bind' => [
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ])->getFirst();

        if (!$translate)
        {
            return "title not set in language";
        }

        return $translate->getTitle();
    }

    public function getLivePrice()
    {
        /** @var ModelCurrencyPrice $price */
        $price = $this->getPrices([
            'order' => 'created desc'
        ])->getFirst();

        if (!$price)
        {
            return 0;
        }

        return $price->getPrice();
    }

    public function getTimeLivePrice()
    {
        /** @var ModelCurrencyPrice $price */
        $price = $this->getPrices([
            'order' => 'created desc'
        ])->getFirst();

        if (!$price)
        {
            return false;
        }

        return $price->getCreated();
    }

    public function getPercentageChange()
    {
        $endTimeYesterday = Date::getEndOfDay(Date::getYesterday());

        /** @var ModelCurrencyPrice $price */
        $price = $this->getPrices([
            'conditions' => 'created < :created:',
            'order' => 'created desc',
            'bind' => [
                'created' => $endTimeYesterday
            ]
        ])->getFirst();

        if (!$price)
        {
            return 0;
        }

        $lastPrice = $price->getPrice();
        $livePrice = $this->getLivePrice();

        return round( (($livePrice - $lastPrice ) / $livePrice)*100, 2);
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Relations
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelCurrencyPrice::class,
            'currency_id',
            [
                'alias' => 'Prices',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->hasMany(
            'id',
            ModelCurrencyTranslate::class,
            'currency_id',
            [
                'alias' => 'Translates',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->belongsTo(
            'category_id',
            ModelCurrencyCategory::class,
            'id',
            [
                'alias' => 'Category',
                'foreignKey' => true
            ]
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