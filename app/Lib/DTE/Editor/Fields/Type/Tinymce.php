<?php
namespace Lib\DTE\Editor\Fields\Type;


use Lib\DTE\Editor\Fields\Field;

class Tinymce extends Field
{
    protected $opts;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->type = 'tinymce';
    }

    public function init()
    {
        parent::init();
        $this->getEditor()->assetsManager->addJs('assets/tinymce/tinymce.min.js');
        $this->getEditor()->assetsManager->addJs('dt/js/editor.tinymce.js');
    }

    public function toArray()
    {
        $out = parent::toArray();

        if($this->opts)
            $out['opts'] = $this->opts;

        return $out;
    }

    /**
     * @return mixed
     */
    public function getOpts()
    {
        return $this->opts;
    }

    /**
     * @param mixed $opts
     */
    public function setOpts( $opts )
    {
        $this->opts = $opts;
    }

    public function setOpt( $key, $value )
    {
        $this->opts[$key] = $value;
    }

    public function addOpt( $key, $value )
    {
        $this->opts[$key] = $value;
    }

}