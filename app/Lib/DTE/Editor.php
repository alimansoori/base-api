<?php
namespace Lib\DTE;

use Lib\DTE\Editor\Template;

abstract class Editor extends BaseEditor
{
    /** @var Template */
    protected $template;

    public function __construct( $name )
    {
        parent::__construct($name);
        $this->template = new Template($this);
    }

    public function render() { return null; }
}