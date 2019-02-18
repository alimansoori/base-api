<?php
namespace Lib\DTE\Table;


use Lib\DTE\Ajax\AjaxCommon;
use Lib\DTE\Table;
use Lib\Enums\RequestTypes;
use Lib\DTE\Table\Ajax\Data;

class Ajax extends AjaxCommon
{
    public function __construct( Table $table)
    {
        parent::__construct();
        $this->table = $table;
        $this->data['name'] = $table->getName();
    }

    public function toArray()
    {
        $output = parent::toArray();

        return $output;
    }
}