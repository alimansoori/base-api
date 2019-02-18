<?php
namespace Modules\System\Permission\Models\Roles;


trait Properties
{
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *  Fields
     */

    private $id;
    private $module_id;
    private $language_iso;
    private $name;
    private $title;
    private $description;
    private $status;
    private $position;
    private $created;
    private $modified;

    public function getId()
    {
        return $this->id;
    }

    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * @param mixed $module_id
     */
    public function setModuleId( $module_id )
    {
        $this->module_id = $module_id;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle( $title ): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription( $description )
    {
        $this->description = $description;
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
    public function setStatus( $status ): void
    {
        $this->status = $status;
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