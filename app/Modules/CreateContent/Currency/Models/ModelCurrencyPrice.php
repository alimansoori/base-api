<?php
namespace Modules\CreateContent\Currency\Models;


use Lib\Mvc\Model;
use Phalcon\Validation\Validator\Numericality;

/**
 * @method ModelCurrency getCurrency()
 */
class ModelCurrencyPrice extends Model
{
    private $id;
    private $currency_id;
    private $price;
    private $created;
    private $modified;

    protected function init()
    {
        $this->setSource('currency_price');
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * */
    /* Relations
    /* * * * * * * * * * * * * * * * * * * * * * * * */

    protected function relations()
    {
        $this->belongsTo(
            'currency_id',
            ModelCurrency::class,
            'id',
            [
                'alias' => 'Prices',
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
            'price',
            new Numericality()
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
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * @param mixed $currency_id
     */
    public function setCurrencyId($currency_id): void
    {
        $this->currency_id = $currency_id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
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