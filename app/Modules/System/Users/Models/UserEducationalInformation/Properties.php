<?php
namespace Modules\System\Users\Models\UserEducationalInformation;


trait Properties
{
    private $id;
    private $user_id;
    private $level;
    private $field;

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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel( $level ): void
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField( $field ): void
    {
        $this->field = $field;
    }


}