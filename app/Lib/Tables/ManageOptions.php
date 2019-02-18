<?php
namespace Lib\Tables;


use Phalcon\Config;

trait ManageOptions
{
    protected $options = [];

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getOption(string $key)
    {
        if(!isset($this->options[$key]))
            throw new Exception('Options for key does not exist');

        return $this->options[$key];
    }

    public function addOptions(array $options)
    {
        if(!is_array($options))
            throw new Exception('Options param must be array');

        $this->options = array_merge($this->options, $options);
    }

    public function addOption(string $key, $value)
    {
        if(!(is_array($value) || is_string($value) || is_bool($value) || is_integer($value)))
            throw new Exception('Options param must be array or string');

        if(isset($this->options[$key]) && is_array($this->options[$key]))
        {
            $conf1 = new Config($value);
            $conf2 = new Config($this->options[$key]);

//            $this->options[$key] = $conf1->merge($conf2);
            $this->options[$key] = $conf2->merge($conf1);
        }
        else
            $this->options[$key] = $value;
    }

    public function isOption(string $key): bool
    {
        if(!isset($this->options[$key]))
            return false;

        return true;
    }
}