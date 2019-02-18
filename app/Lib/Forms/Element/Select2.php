<?php
namespace Lib\Forms\Element;

use Lib\Contents\ContentBuilder;
use Lib\Forms\Element\Select2\Options;

class Select2 extends Select
{
    public $opts;

    public function __construct( $name, $options = null, $attributes = null )
    {
        parent::__construct( $name, $options, $attributes );
        $this->_type = 'select2';
        $this->opts = new Options($this);

        $content = ContentBuilder::instantiate();

        $content->assetsCollection->addCss('assets/select2/dist/css/select2.min.css');
        $content->assetsCollection->addJs('assets/select2/dist/js/select2.min.js');
    }

    /**
     * @return array
     */
    public function getOpts()
    {
        if(!$this->opts->isActive())
            return null;

        $opts = [];
        if($this->opts->ajax->isActive())
            $opts['ajax'] = $this->opts->getAjax();

        if($this->opts->getPlaceholder())
            $opts['placeholder'] = $this->opts->getPlaceholder();

        if($this->opts->getTemplateResult())
            $opts['templateResult'] = $this->opts->getTemplateResult();

        if($this->opts->getTemplateSelection())
            $opts['templateSelection'] = $this->opts->getTemplateSelection();

        if($this->opts->getEscapeMarkup())
            $opts['escapeMarkup'] = $this->opts->getEscapeMarkup();

        return $opts;
    }
}