<?php
namespace Modules\CreateContent\Currency\Tables;


use Lib\Tables\Adapter\Table;
use Lib\Tables\Column;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

class WidgetPricesTable extends Table
{
    public function init(): void
    {
        $this->addOption('serverSide', true);
        $this->addOption('ordering', false);

        $this->assetsManager->addCss('assets/datatables.net-rowgroup-dt/css/rowGroup.dataTables.min.css');
        $this->assetsManager->addJs('assets/datatables.net-rowgroup/js/dataTables.rowGroup.min.js');
        $this->addOption('rowGroup', ['dataSrc' => 'category_name']);
        $this->setDom('rt');

        $this->ajax->setUrl($this->url->get([
            'for' => 'api_get_widget_prices__'. ModelLanguage::getCurrentLanguage()
        ]));

        $this->setTimerEvent(3000);

        $this->setClassNames([
            'display',
            'row-border',
            'cell-border'
        ]);
    }

    public function initButtons(): void
    {
        // TODO: Implement initButtons() method.
    }

    public function initColumns(): void
    {
        $this->columnTitle();
        $this->columnLivePrice();
        $this->columnPercent();
        $this->columnMinPrice();
        $this->columnMaxPrice();
        $this->columnTime();
    }

    private function columnTitle()
    {
        $title = new Column('title');
        $title->setTitle(T::_('title'));
        $title->setClassName('dt-center');
        $this->addColumn($title);
    }

    private function columnPercent()
    {
        $column = new Column('percent');
        $column->setTitle(T::_('percent'));
        $column->setClassName('dt-center ltr-dir');
        $column->setRender(<<<TAG
        if(type=='display'){return data+' %';}
        return data;
TAG
);
        $this->addColumn($column);
    }

    private function columnLivePrice()
    {
        $column = new Column('live_price');
        $column->setTitle(T::_('live_price'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    private function columnMinPrice()
    {
        $column = new Column('min');
        $column->setTitle(T::_('min_price'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    private function columnMaxPrice()
    {
        $column = new Column('max');
        $column->setTitle(T::_('max_price'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    private function columnTime()
    {
        $column = new Column('time');
        $column->setTitle(T::_('time'));
        $column->setClassName('dt-center');
        $this->addColumn($column);
    }

    public function initEditors(): void
    {
        // TODO: Implement initEditors() method.
    }

    private function setTimerEvent($delay = 10000)
    {
        $this->assetsManager->addInlineCss(/** @lang CSS */
            <<<TAG
            .ltr-dir{direction: ltr;}
            .rtl-dir{direction: rtl;}
            .tr-high{background: #ccffcc !important;}
            .tr-low{background: #ffcace !important;}
TAG
);
        $this->assetsManager->addInlineJsBottom(<<<TAG
        setInterval(function(){ {$this->getName()}.ajax.reload(); }, $delay);
        
        {$this->getName()}.on( 'draw', function (e, setting) {
            {$this->getName()}.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                var row = this.node();
                if (typeof data.status !== 'undefined') {
                    if ( data.status == 'high') { $(row).addClass('tr-high'); }
                    if ( data.status == 'low') { $(row).addClass('tr-low'); }
                }
            } );
} );
TAG
        );
    }
}