<?php
namespace Modules\System\Users\Models\UserCompanyInformation;


trait Properties
{
    private $id;
    private $user_id;
    private $type;
    private $name;
    private $economic_code;
    private $national_code;
    private $register_code;
    private $responsibility;
    private $personnel_code;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType( $type ): void
    {
        $this->type = $type;
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
    public function setName( $name ): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEconomicCode()
    {
        return $this->economic_code;
    }

    /**
     * @param mixed $economic_code
     */
    public function setEconomicCode( $economic_code ): void
    {
        $this->economic_code = $economic_code;
    }

    /**
     * @return mixed
     */
    public function getNationalCode()
    {
        return $this->national_code;
    }

    /**
     * @param mixed $national_code
     */
    public function setNationalCode( $national_code ): void
    {
        $this->national_code = $national_code;
    }

    /**
     * @return mixed
     */
    public function getRegisterCode()
    {
        return $this->register_code;
    }

    /**
     * @param mixed $register_code
     */
    public function setRegisterCode( $register_code ): void
    {
        $this->register_code = $register_code;
    }

    /**
     * @return mixed
     */
    public function getResponsibility()
    {
        return $this->responsibility;
    }

    /**
     * @param mixed $responsibility
     */
    public function setResponsibility( $responsibility ): void
    {
        $this->responsibility = $responsibility;
    }

    /**
     * @return mixed
     */
    public function getPersonnelCode()
    {
        return $this->personnel_code;
    }

    /**
     * @param mixed $personnel_code
     */
    public function setPersonnelCode( $personnel_code ): void
    {
        $this->personnel_code = $personnel_code;
    }
}