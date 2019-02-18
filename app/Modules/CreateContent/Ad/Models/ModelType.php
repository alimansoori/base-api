<?php
namespace Modules\CreateContent\Ad\Models;


/**
 * @method ModelFields[] getFields()
 */
class ModelType extends BaseModel
{
    private $id;
    private $name;

    protected function init()
    {
        $this->setSource('type');
    }

    protected function relations()
    {
        $this->hasMany(
            'name',
            ModelFields::class,
            'type_name',
            [
                'alias' => 'Fields',
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}