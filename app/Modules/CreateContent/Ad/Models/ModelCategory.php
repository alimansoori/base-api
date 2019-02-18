<?php
namespace Modules\CreateContent\Ad\Models;


use Modules\CreateContent\Ad\Models\ModelCategory\TValidation;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * @method ModelAd[]                getAds()
 * @method ModelCategory            getParent()
 * @method ModelCategory[]          getChilds()
 * @method ModelCategoryFields[]    getCategoryFields()
 */
class ModelCategory extends BaseModel
{
    private $id;
    private $parent_id;
    private $title;
    private $description;
    private $position;
    private $created;
    private $modified;

    use TValidation;

    protected function init()
    {
        $this->setSource('category');
    }

    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelAd::class,
            'category_id',
            [
                'alias' => 'Ads',
                'foreignKey' => true
            ]
        );

        $this->hasMany(
            'id',
            self::class,
            'parent_id',
            [
                'alias' => 'Childs',
                'foreignKey' => true
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

        $this->hasMany(
            'id',
            ModelCategoryFields::class,
            'category_id',
            [
                'alias' => 'CategoryFields',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );
    }

    /**
     * @return ModelCategoryFields[]|array
     */
    public function getHierarchyFields()
    {
        $fields = [];

        if (!empty($this->getCategoryFields()->toArray()))
        {
            foreach ($this->getCategoryFields(['order'=>'position']) as $categoryField)
            {
                $fields[] = $categoryField;
            }

            if ($this->getParentId())
            {
                $fields = array_merge($fields, $this->getParent()->getHierarchyFields());
            }
        }

        return $fields;
    }

    /**
     * @param null|ModelAd $editAd
     * @return array
     */
    public function getFieldsEditor($editAd = null)
    {
        $fields = [];
        foreach ($this->getHierarchyFields() as $categoryField)
        {
            $field = [
                'name'        => $categoryField->getId(),
                'data'        => $categoryField->getId(),
                'type'        => $categoryField->getField()->getTypeName(),
                'options'     => $categoryField->getField()->getOptions([
                    'columns' => 'label, value',
                    'conditions' => 'value<>:except: OR value IS NULL',
                    'order' => 'position',
                    'bind' => [
                        'except' => -100
                    ]
                ])->toArray()
            ];

            if ($categoryField->getField()->getLabel())
                $field['label'] = $categoryField->getField()->getLabel();
            if ($categoryField->getField()->getFieldInfo())
                $field['fieldInfo'] = $categoryField->getField()->getFieldInfo();

            if (!$editAd)
            {
                if ($categoryField->getField()->getDef())
                    $field['def'] = $categoryField->getField()->getDef();
            }
            else
            {
                /** @var ModelAdDetails $fieldDetail */
                $fieldDetail = $editAd->getDetails([
                    'conditions' => 'category_field_id=:cat_field_id:',
                    'bind' => [
                        'cat_field_id' => $categoryField->getId()
                    ]
                ])->getFirst();

                if ($fieldDetail)
                {
                    $field['def'] = $fieldDetail->getValue();
                }
            }

            if ($categoryField->getField()->getLabelInfo())
                $field['labelInfo'] = $categoryField->getField()->getLabelInfo();
            if ($categoryField->getField()->getMessage())
                $field['message'] = $categoryField->getField()->getMessage();
            if ($categoryField->getField()->getClassName())
                $field['className'] = $categoryField->getField()->getClassName();

            $fields[$categoryField->getId()] = $field;
        }

        return $fields;
    }

    public function getFieldsDefSearch()
    {
        $fields = [];
        foreach ($this->getHierarchyFields() as $categoryField)
        {
            $field = [
                'name'        => $categoryField->getId(),
                'data'        => $categoryField->getId(),
                'type'        => $categoryField->getField()->getTypeName(),
                'options'     => $categoryField->getField()->getOptions([
                    'columns' => 'label, value',
                    'conditions' => 'value<>:except: OR value IS NULL',
                    'order' => 'position',
                    'bind' => [
                        'except' => -100
                    ]
                ])->toArray()
            ];

            if ($categoryField->getField()->getLabel())
                $field['label'] = $categoryField->getField()->getLabel();
            if ($categoryField->getField()->getFieldInfo())
                $field['fieldInfo'] = $categoryField->getField()->getFieldInfo();

            if ($categoryField->getField()->getDefSearch())
                $field['def'] = $categoryField->getField()->getDefSearch();

            if ($categoryField->getField()->getLabelInfo())
                $field['labelInfo'] = $categoryField->getField()->getLabelInfo();
            if ($categoryField->getField()->getMessage())
                $field['message'] = $categoryField->getField()->getMessage();
            if ($categoryField->getField()->getClassName())
                $field['className'] = $categoryField->getField()->getClassName();

            $fields[$categoryField->getId()] = $field;
        }

        return $fields;
    }

    /**
     * @return array
     */
    public function getFieldsEditorSearch($query = null)
    {
        $fields = [];
        foreach ($this->getHierarchyFields() as $categoryField)
        {
            $field = [
                'name'        => $categoryField->getId(),
                'data'        => $categoryField->getId(),
                'type'        => $categoryField->getField()->getTypeName(),
                'options'     => $categoryField->getField()->getOptions([
                    'columns' => 'label, value',
                    'conditions' => 'value<>:except: OR value IS NULL',
                    'order' => 'position',
                    'bind' => [
                        'except' => -1111111
                    ]
                ])->toArray()
            ];

            if ($categoryField->getField()->getLabel())
                $field['label'] = $categoryField->getField()->getLabel();
            if ($categoryField->getField()->getFieldInfo())
                $field['fieldInfo'] = $categoryField->getField()->getFieldInfo();

            if (isset($query[$categoryField->getId()]))
            {
                $field['def'] = $query[$categoryField->getId()];
            }
            elseif ($categoryField->getField()->getDefSearch())
            {
                $field['def'] = $categoryField->getField()->getDefSearch();
            }

            if ($categoryField->getField()->getLabelInfo())
                $field['labelInfo'] = $categoryField->getField()->getLabelInfo();
            if ($categoryField->getField()->getMessage())
                $field['message'] = $categoryField->getField()->getMessage();
            if ($categoryField->getField()->getClassName())
                $field['className'] = $categoryField->getField()->getClassName();

            $fields[] = $field;
        }

        return $fields;
    }

    /* * * * * * * * * * * * * * */
    /*  Public Methods
    /* * * * * * * * * * * * * * */

    /**
     * @return self[]
     */
    public function getParentListComplateObject()
    {
        $parents = [];

        if ($this->getParentId())
        {
            $parents[] = $this->getParent();
            $parents = array_merge($parents, $this->getParent()->getParentListComplateObject());
        }

        return $parents;
    }

    public function getParentList()
    {
        $parents = [];

        if ($this->getParentId())
        {
            $parents[] = $this->getParent()->getId();
            $parents = array_merge($parents, $this->getParent()->getParentList());
        }

        return $parents;
    }

    public function getChildList()
    {
        $row = [];

        if (!empty($this->getChilds()->toArray()))
        {
            foreach ($this->getChilds() as $child)
            {
                $row[] = $child->getId();
                $row = array_merge($row, $child->getChildList());
            }
        }

        return $row;
    }

    public static function getLeaves()
    {
        /** @var ModelCategory[] $categories */
        $categories = self::find();

        $leaves = [];

        foreach ($categories as $category)
        {
            if (empty($category->getChildList()))
            {
                $leaves[$category->getId()] = $category;
            }
        }

        return $leaves;
    }

    /* * * * * * * * * * * * * * */
    /*  Fields
    /* * * * * * * * * * * * * * */

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