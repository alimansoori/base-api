<?php
namespace Lib\Tables\Buttons\Printt;


use Lib\DTE\Table\Button;

class Printt extends Button implements IPrint
{
    public function __construct()
    {
        $this->extend = 'print';
    }

    public function init()
    {
        parent::init();
        $this->getTable()->jsHigh->addJs('assets/datatables.net-buttons/js/buttons.print.js');
    }
}