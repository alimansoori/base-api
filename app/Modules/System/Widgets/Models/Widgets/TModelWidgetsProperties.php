<?php

namespace Modules\System\Widgets\Models\Widgets;

trait TModelWidgetsProperties
{
    private $id;
    private $module_id;
    private $name;
    private $namespace;
    private $position;
    private $created;
    private $modified;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( $name )
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
    public function setTitle( $title )
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace( $namespace )
    {
        $this->namespace = $namespace;
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
    public function setDescription( $description )
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent( $content )
    {
        $this->content = $content;
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
    public function setPosition( $position )
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
    public function setCreated( $created )
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
    public function setModified( $modified )
    {
        $this->modified = $modified;
    }
}