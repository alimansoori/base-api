<?php
namespace Modules\System\PageManager\Models\Routes;


trait TModelRoutesProperties
{
    private $id;
    private $name;
    private $language_iso;
    private $creator_id;
    private $resource_id;
    private $title;
    private $pattern;
    private $type;
    private $module;
    private $controller;
    private $action;
    private $params;
    private $namespace;
    private $int;
    private $sample;
    private $validation_pattern;    // Regex pattern
    private $http_methods;          // GET,POST,PUT,PATCH,DELETE,OPTIONS,HEAD,PURGE,TRACE,CONNECT

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
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param mixed $pattern
     */
    public function setPattern( $pattern )
    {
        $this->pattern = $pattern;
    }

    /**
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resource_id;
    }

    /**
     * @param mixed $resource_id
     */
    public function setResourceId( $resource_id ): void
    {
        $this->resource_id = $resource_id;
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
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule( $module )
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController( $controller )
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction( $action )
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams( $params )
    {
        $this->params = $params;
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
    public function getInt()
    {
        return $this->int;
    }

    /**
     * @param mixed $int
     */
    public function setInt( $int )
    {
        $this->int = $int;
    }

    /**
     * @return mixed
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * @param mixed $sample
     */
    public function setSample( $sample )
    {
        $this->sample = $sample;
    }

    /**
     * @return mixed
     */
    public function getValidationPattern()
    {
        return $this->validation_pattern;
    }

    /**
     * @param mixed $validation_pattern
     */
    public function setValidationPattern( $validation_pattern )
    {
        $this->validation_pattern = $validation_pattern;
    }

    /**
     * @return mixed
     */
    public function getHttpMethods()
    {
        return $this->http_methods;
    }

    /**
     * @param mixed $http_methods
     */
    public function setHttpMethods( $http_methods )
    {
        $this->http_methods = $http_methods;
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
    public function setLanguageIso( $language_iso )
    {
        $this->language_iso = $language_iso;
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
    public function getCreatorId()
    {
        return $this->creator_id;
    }

    /**
     * @param mixed $creator_id
     */
    public function setCreatorId( $creator_id ): void
    {
        $this->creator_id = $creator_id;
    }
}