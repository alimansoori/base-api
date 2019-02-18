<?php
namespace Lib\Forms\Element\Select2;


use Lib\Forms\Element\Select2;

class Ajax
{
    private $select2;
    private $url;
    private $dataSrc;
    private $data;
    private $type = 'POST';
    private $processResults;

    private $active = false;

    public function __construct(Select2 $select2)
    {
        $this->select2 = $select2;
        $this->setDataSrc('json');
    }

    /**
     * @return Select2
     */
    public function getSelect2()
    {
        return $this->select2;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl( $url )
    {
        $this->active = true;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getDataSrc()
    {
        return $this->dataSrc;
    }

    /**
     * @param mixed $dataSrc
     */
    public function setDataSrc( $dataSrc )
    {
        $this->active = true;
        $this->dataSrc = $dataSrc;
    }

    /**
     * @return mixed
     */
    public function getProcessResults()
    {
        return $this->processResults;
    }

    /**
     * @param mixed $processResults
     */
    public function setProcessResults( $processResults )
    {
        $this->active = true;
        $this->processResults = "||".$processResults."||";
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
        $this->active = true;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData( $data )
    {
        $this->active = true;
        $this->data = "||".$data."||";
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}