<?php
namespace Modules\CreateContent\Ad\Models;


use Lib\Mvc\Model\ModelBlobs;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Mvc\Model\Message;

/**
 * @method ModelBlobs    getImage()
 * @method ModelAd       getAd()
 * @method ModelUsers    getUser()
 */
class ModelAdImage extends BaseModel
{
    private $id;
    private $image_id;
    private $ad_id;
    private $user_id;
    private $title;
    private $position;
    private $created;
    private $modified;

    protected function init()
    {
        $this->setSource('ad_image');
    }

    protected function relations()
    {
        $this->belongsTo(
            'image_id',
            ModelBlobs::class,
            'id',
            [
                'alias' => 'Image',
                'foreignKey' => true
            ]
        );

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
            'user_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'User',
                'foreignKey' => true
            ]
        );
    }

    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();

        if (!$this->getUserId() && $this->getDI()->getShared('auth')->isLoggedIn())
        {
            $this->setUserId($this->getDI()->getShared('auth')->getUserId());
        }

        // number image allow
        if ($this->getAdId())
        {
            /** @var self[] $images */
            $images = self::findByAdId($this->getAdId());

            if (count($images) >= 5 )
            {
                $this->appendMessage(
                    new Message('حداکثر تعداد تصاویر مجاز برای آگهی 5 عدد  می باشد.', 'error')
                );

                return false;
            }
        }
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
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @param mixed $image_id
     */
    public function setImageId($image_id): void
    {
        $this->image_id = $image_id;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
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