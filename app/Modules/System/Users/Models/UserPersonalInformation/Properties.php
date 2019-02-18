<?php
namespace Modules\System\Users\Models\UserPersonalInformation;


trait Properties
{
    private $id;
    private $user_id;
    private $first_name;
    private $last_name;
    private $parent_name;
    private $id_number;
    private $place_of_birth;
    private $gender;
    private $date_of_birth;
    private $national_code;
    private $mobile;
    private $phone;
    private $fax;
    private $state;
    private $city;
    private $postal_code;
    private $address;

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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName( $first_name ): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName( $last_name ): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getParentName()
    {
        return $this->parent_name;
    }

    /**
     * @param mixed $parent_name
     */
    public function setParentName( $parent_name ): void
    {
        $this->parent_name = $parent_name;
    }

    /**
     * @return mixed
     */
    public function getIdNumber()
    {
        return $this->id_number;
    }

    /**
     * @param mixed $id_number
     */
    public function setIdNumber( $id_number ): void
    {
        $this->id_number = $id_number;
    }

    /**
     * @return mixed
     */
    public function getPlaceOfBirth()
    {
        return $this->place_of_birth;
    }

    /**
     * @param mixed $place_of_birth
     */
    public function setPlaceOfBirth( $place_of_birth ): void
    {
        $this->place_of_birth = $place_of_birth;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender( $gender ): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param mixed $date_of_birth
     */
    public function setDateOfBirth( $date_of_birth ): void
    {
        $this->date_of_birth = $date_of_birth;
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
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile( $mobile ): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone( $phone ): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax( $fax ): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState( $state ): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity( $city ): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode( $postal_code ): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress( $address ): void
    {
        $this->address = $address;
    }
}