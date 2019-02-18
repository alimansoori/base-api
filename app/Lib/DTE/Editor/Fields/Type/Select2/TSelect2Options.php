<?php
namespace Lib\DTE\Editor\Fields\Type\Select2;


trait TSelect2Options
{
    protected $opts = [];
    protected $separator;
    protected $onFocus;

    /**
     * @return array
     */
    public function getOpts()
    {
        return $this->opts;
    }

    /**
     * @param array $opts
     */
    public function setOpts( $opts )
    {
        $this->opts = $opts;
    }

    public function addOpt( $key, $value )
    {
        $this->opts[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param mixed $separator
     */
    public function setSeparator( $separator )
    {
        $this->separator = $separator;
    }

    /**
     * @return mixed
     */
    public function getOnFocus()
    {
        return $this->onFocus;
    }

    /**
     * @param mixed $onFocus
     */
    public function setOnFocus( $onFocus )
    {
        if($onFocus)
            $this->onFocus = 'open';
        else
            $this->onFocus = null;
    }
}