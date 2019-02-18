<?php
namespace Lib\Editors\Fields\Type;

use Lib\Editors\Fields\Field;
use Lib\Editors\Fields\Type\Mask\TSelect2Options;

class Mask extends Field
{
    use TSelect2Options;

    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setType('mask');

    }

    public function init()
    {
        parent::init();
        $this->getEditor()->assetsManager->addJs('assets/jQuery-Mask-Plugin/dist/jquery.mask.min.js');
        $this->getEditor()->assetsManager->addJs('dt/js/editor.mask.js');
    }

    public function toArray()
    {
        $output = parent::toArray();

        if($this->mask)
            $output['mask'] = $this->mask;
        if($this->placeholder)
            $output['placeholder'] = $this->placeholder;
        if($this->maskOptions)
            $output['maskOptions'] = $this->maskOptions;

        return $output;
    }
}