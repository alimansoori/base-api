<?php
namespace Lib\DTE\Ajax;


use Lib\Common\Strings;

abstract class AjaxData
{
    /** @var AjaxCommon $ajax */
    protected $ajax;
    protected $data = [];

    public function __construct($ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * @return string
     */
    public function getData()
    {
        $data = "||";
        $data .= "function(d){";

        foreach($this->data as $key=>$value)
        {
            if(!is_numeric($key))
            {
                if(is_numeric($value) || is_bool($value))
                    $data .= "d.$key = $value;";
                if(is_string($value))
                    $data .= "d.$key = '$value';";
            }
            else
            {
                $data .= $value;
            }
        }

//        $data .= $this->getParentChildData();

        $data .= "} ||";
        return Strings::multilineToSingleline($data);
    }

    /**
     * @param array $data
     */
    public function setData( $data )
    {
        $this->data = $data;
    }

    public function addData( $key, $value )
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $value
     */
    public function addJsData( $value )
    {
        $this->data[] = $value;
    }
}