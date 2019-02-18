<?php
namespace Lib\DTE\Editor\Fields\Type;


use Lib\DTE\Editor\Fields\Field;

class Ckeditor extends Field
{
    protected $opts;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->type = 'ckeditor';
    }

    public function init()
    {
        parent::init();
        $this->getEditor()->assets->addJs('https://cdn.ckeditor.com/4.11.4/full/ckeditor.js', false);
        $this->getEditor()->assetsManager->addJs('assets/ckeditor/ckeditor.js');
        $this->getEditor()->assetsManager->addJs('dt/js/editor.ckeditor.js');
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