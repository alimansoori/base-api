<?php
namespace Modules\System\Users\Models\UserFurtherInformation;


trait Properties
{
    protected $id;
    protected $user_id;
    protected $profile_url;
    protected $blog_address;
    protected $signature;
    protected $favorites;
    protected $avatar_address;
    protected $description;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId( $user_id ): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getProfileUrl()
    {
        return $this->profile_url;
    }

    /**
     * @param mixed $profile_url
     */
    public function setProfileUrl( $profile_url ): void
    {
        $this->profile_url = $profile_url;
    }

    /**
     * @return mixed
     */
    public function getBlogAddress()
    {
        return $this->blog_address;
    }

    /**
     * @param mixed $blog_address
     */
    public function setBlogAddress( $blog_address ): void
    {
        $this->blog_address = $blog_address;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature( $signature ): void
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * @param mixed $favorites
     */
    public function setFavorites( $favorites ): void
    {
        $this->favorites = $favorites;
    }

    /**
     * @return mixed
     */
    public function getAvatarAddress()
    {
        return $this->avatar_address;
    }

    /**
     * @param mixed $avatar_address
     */
    public function setAvatarAddress( $avatar_address ): void
    {
        $this->avatar_address = $avatar_address;
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
    public function setDescription( $description ): void
    {
        $this->description = $description;
    }
}