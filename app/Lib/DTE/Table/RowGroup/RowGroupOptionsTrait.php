<?php
namespace Lib\DTE\Table\RowGroup;


trait RowGroupOptionsTrait
{
    /** @var string */
    protected $className;       // def => group
    /** @var array|int */
    protected $dataSrc;         // def => 0
    /** @var string|null */
    protected $emptyDataGroup;  // def No group
    /** @var boolean */
    protected $enable;          // def true
    /** @var string */
    protected $endClassName;    // def group-end
    /** @var null|string */
    protected $endRender;       // def null
    /** @var string */
    protected $startClassName;  // def group-start
    /** @var null|string */
    protected $startRender;     // def function (rows, data) { return data; }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName( $className )
    {
        $this->className = $className;
    }

    /**
     * @return array|int
     */
    public function getDataSrc()
    {
        return $this->dataSrc;
    }

    /**
     * @param array|int $dataSrc
     */
    public function setDataSrc( $dataSrc )
    {
        $this->dataSrc = $dataSrc;
    }

    /**
     * @return string|null
     */
    public function getEmptyDataGroup()
    {
        return $this->emptyDataGroup;
    }

    /**
     * @param string|null $emptyDataGroup
     */
    public function setEmptyDataGroup( $emptyDataGroup )
    {
        $this->emptyDataGroup = $emptyDataGroup;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable( $enable )
    {
        $this->enable = $enable;
    }

    /**
     * @return string
     */
    public function getEndClassName()
    {
        return $this->endClassName;
    }

    /**
     * @param string $endClassName
     */
    public function setEndClassName( $endClassName )
    {
        $this->endClassName = $endClassName;
    }

    /**
     * @return string|null
     */
    public function getEndRender()
    {
        return $this->endRender;
    }

    /**
     * @param string|null $endRender
     */
    public function setEndRender( $endRender )
    {
        $this->endRender = $endRender;
    }

    /**
     * @return string
     */
    public function getStartClassName()
    {
        return $this->startClassName;
    }

    /**
     * @param string $startClassName
     */
    public function setStartClassName( $startClassName )
    {
        $this->startClassName = $startClassName;
    }

    /**
     * @return string|null
     */
    public function getStartRender()
    {
        return $this->startRender;
    }

    /**
     * @param string|null $startRender
     */
    public function setStartRender( $startRender )
    {
        $this->startRender = $startRender;
    }

}