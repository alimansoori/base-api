<?php
namespace Lib\DTE\Ajax;


use Lib\Common\Strings;
use Lib\DTE\Editor;
use Lib\DTE\Table;
use Phalcon\Mvc\User\Component;

class AjaxCommon extends Component
{
    /** @var Editor */
    protected $editor;
    /** @var Table */
    protected $table;

    protected $_url;
    protected $data;
    /** @var string */
    protected $dataType;
    /** @var string */
    protected $type = 'POST';

    public function __construct()
    {
//        $this->_url = $this->url->get([
//            'for' => $this->router->getMatchedRoute()->getName()
//        ]);
        $this->_url = $this->url->get($this->router->getRewriteUri());

    }

    public function toArray()
    {
        $out = [];

        if($this->_url)
            $out['url'] = $this->_url;
        if($this->type)
            $out['type'] = $this->type;
        if($this->dataType)
            $out['dataType'] = $this->dataType;
        if(is_array($this->data))
            $out['data'] = $this->getData(false);

        return $out;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl( $url )
    {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType( $dataType )
    {
        $this->dataType = $dataType;
    }

    /**
     * @param bool $isArray
     * @return mixed
     */
    public function getData($isArray=true)
    {
        if($isArray)
            return $this->data;

        $data = "||function(d){";

        foreach($this->data as $key=>$value)
        {
            if(!is_numeric($key))
            {
                if(is_numeric($value) || is_bool($value))
                    $data .= "d.$key = $value;";
                if(is_string($value))
                {
                    if(Strings::IsStartBy($value, '||') && Strings::IsEndBy($value, '||'))
                    {
                        $value = Strings::clean(json_encode($value));
                        $data .= "d.$key = $value;";
                    }
                    else
                        $data .= "d.$key = '$value';";
                }
            }
            else
            {
                $data .= $value;
            }
        }

//      $data .= $this->getParentChildData();

        $data .= "} ||";
        return Strings::multilineToSingleline($data);
    }

    /**
     * @param mixed $data
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

    /**
     * @return Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}