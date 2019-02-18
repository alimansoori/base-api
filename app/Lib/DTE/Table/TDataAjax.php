<?php
namespace Lib\DTE\Table;

use Lib\Mvc\View;
use Phalcon\Http\RequestInterface;

/**
 * @property RequestInterface request
 * @property View             view
 */
trait TDataAjax
{
    protected $data = [];

    abstract public function initData();

    public function processData()
    {
        $this->initData();
    }

    /**
     * @return array
     */
    public function getData()
    {
//        $row = [];
//        foreach($this->data as $data)
//        {
//            $col = [];
//            foreach($data as $key=>$datum)
//            {
//                if(Strings::IsStartBy($datum, '__'))
//                {
//                    $translate = substr($datum, 2);
//                    $col[$key] = T::_($translate);
//                }
//                else
//                {
//                    $col[$key] = $datum;
//                }
//            }
//
//            $row[] = $col;
//        }

        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData( $data )
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function addDatum( $data )
    {
        $this->data[] = $data;
//        if(is_array($data))
//            $this->datatableData[] = $data;
    }

    public function addData($data)
    {
        $this->data = array_merge($this->data, $data);
    }
}