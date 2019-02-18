<?php
namespace Modules\Frontend\HomePage\Tables;


use Lib\DTE\Table\Columns\Column;
use Lib\Tables\Table;

class TableTest extends Table
{
    public function init(): void
    {
        $this->addOption(
            'ajax',
            $this->url->get('get-test')
        );
    }

    public function initColumns(): void
    {
        $col = new Column('title');
        $col->setTitle('Title');
        $this->addColumn($col);
    }
}