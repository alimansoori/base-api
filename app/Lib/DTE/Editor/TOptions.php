<?php
namespace Lib\DTE\Editor;


use Lib\DTE\Editor\EditorException;

trait TOptions
{
    /** @var array */
    protected $options = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     * @return string|array
     * @throws EditorException
     */
    public function getOption($key)
    {
        if(!isset($this->options[$key]))
            throw new EditorException('Options for key does not exist');

        return $this->options[$key];
    }

    /**
     * @param array $options
     * @return TOptions
     * @throws EditorException
     */
    public function addOptions( array $options )
    {
        if(!is_array($options))
            throw new EditorException('Options param must be array');

        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return TOptions
     * @throws EditorException
     */
    public function setOption( $name, $value )
    {
        if(!(is_array($value) || is_string($value)))
            throw new EditorException('Options param must be array or string');

        if(isset($this->options[$name]) && is_array($this->options[$name]))
            $this->options[$name] = array_merge($this->options[$name], $value);
        else
            $this->options[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return TOptions
     * @throws EditorException
     */
    public function addOption( $name, $value )
    {
        if(!(is_array($value) || is_string($value)))
            throw new EditorException('Options param must be array or string');

        if(isset($this->options[$name]) && is_array($this->options[$name]))
            $this->options[$name] = array_merge($this->options[$name], $value);
        else
            $this->options[$name] = $value;

        return $this;
    }
}