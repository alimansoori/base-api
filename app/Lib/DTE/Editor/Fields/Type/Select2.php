<?php
namespace Lib\DTE\Editor\Fields\Type;

use Lib\DTE\Editor\Fields\Type\Select2\TSelect2Options;

class Select2 extends Radio
{
    use TSelect2Options;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('select2');

    }

    public function init()
    {
        parent::init();
        $this->getEditor()->assetsManager->addCss('assets/select2/dist/css/select2.min.css');
        $this->getEditor()->assetsManager->addJs('assets/select2/dist/js/select2.min.js');
        $this->getEditor()->assetsManager->addJs('dt/js/editor.select2.js');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if(!empty($this->getOpts()))
            $output['opts'] = $this->opts;
        if($this->separator)
            $output['separator'] = $this->separator;
        if($this->onFocus)
            $output['onFocus'] = $this->onFocus;

        return $output;
    }
}