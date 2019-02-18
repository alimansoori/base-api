<?php
namespace Lib\Tables;


use Lib\Common\Strings;

class Ajax implements AjaxInterface
{
    /** @var Adapter */
    protected $table;

    protected $data = [];

    public function __construct($table)
    {
        $this->table = $table;
        $this->data['name'] = $table->getName();
    }

    public function getUrl(): string
    {
        if (!$this->table->isOption('ajax'))
            return null;

        if (!isset($this->table->getOption('ajax')['url']))
            return null;

        return $this->table->getOption('ajax')['url'];
    }

    public function setUrl(string $url): void
    {
        $this->table->addOption('ajax', [
            'url' => $url
        ]);
    }

    public function addData(string $key, $value): void
    {
        $this->data[$key] = $value;
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

    public function getDataSrc(): string
    {
        if (!$this->table->isOption('ajax'))
            return null;

        if (!isset($this->table->getOption('ajax')['dataSrc']))
            return null;

        return $this->table->getOption('ajax')['dataSrc'];
    }

    public function setDataSrc(string $dataSrc): void
    {
        $this->table->addOption('ajax', [
            'dataSrc' => $dataSrc
        ]);
    }

    public function getTable()
    {
        return $this->table;
    }

    public function process()
    {
        $this->table->addOption('ajax', [
            'data' => Strings::multilineToSingleline("||function(d){".$this->getData(false)."}||")
        ]);
    }

    public function setType(string $type): void
    {
        if (!($type == self::TYPE_GET || $type == self::TYPE_POST))
        {
            throw new Exception('Ajax type is incorrect');
        }

        $this->table->addOption('ajax', [
            'type' => $type
        ]);
    }

    public function getType(): string
    {
        if (!$this->table->isOption('ajax'))
            return null;

        if (!isset($this->table->getOption('ajax')['type']))
            return self::TYPE_GET;

        return $this->table->getOption('ajax')['type'];
    }
}