<?php
namespace Modules\CreateContent\Ad\Models;


use Modules\CreateContent\Ad\Models\ModelAd\TEvents;
use Modules\CreateContent\Ad\Models\ModelAd\TValidation;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * @method ModelCategory        getCategory
 * @method ModelUsers           getUser
 * @method ModelAdDetails[]     getDetails
 * @method ModelAdImage[]     getImages
 */
class ModelAd extends BaseModel
{
    /** @var int $id */
    private $id;
    /** @var int $user_id */
    private $user_id;
    /** @var int $category_id */
    private $category_id;
    /** @var string $title */
    private $title;
    /** @var string $description */
    private $description;
    /** @var int $created */
    private $created;
    /** @var int|null $modified */
    private $modified;
    private $status;

    use TValidation;
    use TEvents;

    protected function init()
    {
        $this->setSource('ad');
    }

    protected function relations()
    {
        $this->belongsTo(
            'category_id',
            ModelCategory::class,
            'id',
            [
                'alias' => 'Category',
                'foreignKey' => true
            ]
        );

        $this->belongsTo(
            'user_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'User',
                'foreignKey' => true
            ]
        );

        $this->hasMany(
            'id',
            ModelAdDetails::class,
            'ad_id',
            [
                'alias' => 'Details',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->hasMany(
            'id',
            ModelAdImage::class,
            'ad_id',
            [
                'alias' => 'Images',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );
    }

    protected function mainValidation()
    {
        $this->validator->add(
            'title',
            new PresenceOf()
        );
    }

    public function beforeValidation()
    {
        parent::beforeValidation();

        if (!$this->getUserId())
        {
            if ($this->getDI()->get('auth')->isLoggedIn())
            {
                $this->setUserId(
                    $this->getDI()->getShared('auth')->getUserId()
                );
            }
        }
    }

    /* * * * * * * * * * * * * * */
    /*  Fields
    /* * * * * * * * * * * * * * */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @param int $created
     */
    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

    /**
     * @return int|null
     */
    public function getModified(): ?int
    {
        return $this->modified;
    }

    /**
     * @param int|null $modified
     */
    public function setModified(?int $modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}