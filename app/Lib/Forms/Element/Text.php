<?php
namespace Lib\Forms\Element;

use Lib\Forms\Design;
use Lib\Forms\Element;
use Lib\Tag;

class Text extends Element
{
    /** @var Design $design */
    public $design;
    public function __construct( $name, array $attributes = null )
    {
        parent::__construct( $name, $attributes );
        $this->_type = 'text';

    }

    public function render( $attributes = null )
    {
        return Tag::textField($this->prepareAttributes($attributes));
    }
}