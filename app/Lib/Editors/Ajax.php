<?php
namespace Lib\Editors;


use Lib\Common\Strings;

class Ajax implements AjaxInterface
{
    /** @var Adapter */
    protected $editor;

    protected $data = [];
    protected $_url = null;
    protected $_type = null;

    public function __construct(Adapter $editor)
    {
        $this->editor = $editor;
        $this->data['name'] = $editor->getName();
    }

    public function getUrl(): string
    {
        return $this->_url;
    }

    public function setUrl(string $url): void
    {
        $this->_url = $url;
    }

    public function addData(string $key, $value): void
    {
        // TODO: Implement addData() method.
    }

    public function setData(array $data = []): void
    {
        $this->data = $data;
    }

    public function getData($isArray=true)
    {
        if($isArray)
            return $this->data;

        $data = "";

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

        return $data;
    }

    public function getEditor()
    {
        return $this->editor;
    }

    public function process()
    {
        $this->editor->addOption('ajax', [
            'url' => $this->_url
        ]);

        $this->editor->addOption('ajax', [
            'type' => $this->_type
        ]);

        $this->editor->addOption('ajax', [
            'data' => Strings::multilineToSingleline("||function(d){".$this->getData(false)."}||")
        ]);
    }

    public function setType(string $type): void
    {
        $this->_type = $type;
    }

    public function getType(): string
    {
        return $this->_type;
    }
}