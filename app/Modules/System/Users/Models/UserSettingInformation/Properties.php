<?php
namespace Modules\System\Users\Models\UserSettingInformation;


trait Properties
{
    private $id;
    private $user_id;
    private $time_zone;
    private $language_iso;

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
    public function getTimeZone()
    {
        return $this->time_zone;
    }

    /**
     * @param mixed $time_zone
     */
    public function setTimeZone( $time_zone ): void
    {
        $this->time_zone = $time_zone;
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
    public function setLanguageIso( $language_iso ): void
    {
        $this->language_iso = $language_iso;
    }
}