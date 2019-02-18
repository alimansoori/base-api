<?php
namespace Lib\DTE\Editor;


use Lib\DTE\Ajax\AjaxCommon;
use Lib\DTE\BaseEditor;
use Lib\DTE\Editor;
use Lib\DTE\Editor\Ajax\Data;

class Ajax extends AjaxCommon
{
    public function __construct( BaseEditor $editor)
    {
        parent::__construct();
        $this->editor = $editor;
        $this->data['name'] = $editor->getName();
    }

    public function toArray()
    {
        $output = parent::toArray();

        return $output;
    }
}