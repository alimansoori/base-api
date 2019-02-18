<?php
namespace Modules\PageManager\Backend\Models;


use Lib\Mvc\Model;
use Modules\PageManager\Backend\Models\ModelCategoryResources\TEvents;
use Modules\PageManager\Backend\Models\ModelCategoryResources\TValidation;

/**
 * @method ModelCategoryResources     getParent()
 * @method ModelCategoryResources[]   getChilds()
 * @method ModelResources[]   getResources()
 */
class ModelCategoryResources extends Model
{
    private $id;
    private $parent_id;
    private $title;
    private $description;
    private $position;
    private $count_child;
    private $created;
    private $modified;

    use TValidation;
    use TEvents;

    public function afterCreate()
    {
        parent::afterCreate();

        if ($this->getParentId())
        {
            /** @var self $parent */
            $parent = self::findFirst($this->getParentId());

            if (!$parent->getCountChild())
            {
                $parent->setCountChild(1);
            }
            elseif (is_numeric($parent->getCountChild()))
            {
                $parent->setCountChild(
                    $parent->getCountChild() + 1
                );
            }

            $parent->update();
        }
    }

    public function beforeUpdate()
    {
        parent::beforeUpdate();

        /** @var self $category */
        $category = self::findFirst($this->getId());

        if ($category && ($this->getParentId() != $category->getParentId()))
        {
            /** @var self $newParent */
            $newParent = self::findFirst($this->getParentId());
            if ($this->getTransaction())
            {
                $newParent->setTransaction($this->getTransaction());
            }

            if (!$newParent->getCountChild())
            {
                $newParent->setCountChild(1);
            }
            elseif (is_numeric($newParent->getCountChild()))
            {
                $newParent->setCountChild(
                    $newParent->getCountChild() + 1
                );

            }

            if (!$newParent->update())
            {
                if ($this->getTransaction())
                {
                    $newParent->getTransaction()->rollback('پدر جدید آپدیت نشد', $newParent);
                }
            }

            /** @var self $oldParent */
            $oldParent = self::findFirst($category->getParentId());

            if ($this->getTransaction())
            {
                $oldParent->setTransaction($this->getTransaction());
            }
            if (is_numeric($oldParent->getCountChild()) && $oldParent->getCountChild() > 1)
            {
                $oldParent->setCountChild(
                    $oldParent->getCountChild() - 1
                );
            }
            else
            {
                $oldParent->setCountChild(null);
            }

            if (!$oldParent->update())
            {
                if ($this->getTransaction())
                {
                    $oldParent->getTransaction()->rollback('پدر قدیمی آپدیت نشد', $oldParent);
                }
            }
        }
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        if ($this->getParentId())
        {
            /** @var self $parent */
            $parent = self::findFirst($this->getParentId());
            if (is_numeric($parent->getCountChild()) && $parent->getCountChild() > 1)
            {
                $parent->setCountChild(
                    $parent->getCountChild() - 1
                );
            }
            else
            {
                $parent->setCountChild(null);
            }

            $parent->update();
        }
    }

    protected function init()
    {
        $this->setSource('category_resources');
    }

    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelResources::class,
            'category_id',
            [
                'alias' => 'Resources',
                'foreignKey' => [
                    'message' => 'تا وقتی که این رکورد منابعی دارد، امکان حذف وجود ندارد.'
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
                    'message' => 'تا وقتی که این رکورد فرزندانی دارد، امکان حذف وجود ندارد.'
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

    /* * * * * * * * * * * * * * */
    /*  Public Methods
    /* * * * * * * * * * * * * * */

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
        /** @var ModelCategoryResources[] $categories */
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
    public function getCountChild()
    {
        return $this->count_child;
    }

    /**
     * @param mixed $count_child
     */
    public function setCountChild($count_child): void
    {
        $this->count_child = $count_child;
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