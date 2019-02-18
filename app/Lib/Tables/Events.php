<?php
namespace Lib\Tables;


use Lib\Mvc\User\Component;

class Events extends Component
{
    protected $table;

    private $onSelect;
    private $onDeselect;
    private $onSelectItems;
    private $onSelectStyle;
    private $onUserSelect;
    private $onColumnSizing;
    private $onColumnVisibility;
    private $onDestroy;
    private $onDraw;
    private $onInit;
    private $onLength;
    private $onOrder;
    private $onPage;
    private $onPreDraw;
    private $onPreInit;
    private $onPreXhr;
    private $onProcessing;
    private $onSearch;
    private $onStateLoadParams;
    private $onStateLoaded;
    private $onStateSaveParams;
    private $onXhr;
    private $onError;
    private $onAutoFill;
    private $onPreAutoFill;
    private $onButtonAction;
    private $onColumnReorder;
    private $onKey;
    private $onKeyBlur;
    private $onKeyFocus;
    private $onKeyReFocus;
    private $onResponsiveDisplay;
    private $onResponsiveResize;
    private $onRowgroupDatasrc;
    private $onPreRowReorder;
    private $onRowReorder;
    private $onRowReordered;

    public function __construct(Adapter $table)
    {
        $this->table = $table;
    }

    public function process()
    {
        $this->processOnSelect();
        $this->processOnDeselct();
        $this->processOnSelectItems();
        $this->processOnSelectStyle();
        $this->processOnUserSelect();
        $this->processColumnSizing();
        $this->processColumnVisibility();
        $this->processDestroy();
        $this->processDraw();
        $this->processError();
        $this->processInit();
        $this->processLength();
        $this->processOrder();
        $this->processPage();
        $this->processPreDraw();
        $this->processPreInit();
        $this->processPreXhr();
        $this->processProcessing();
        $this->processSearch();
        $this->processStateLoadParams();
        $this->processStateSaveParams();
        $this->processXhr();
    }

    public function onXhr($value): void
    {
        $this->onXhr[] = $value;
    }

    private function processXhr()
    {
        if (!$this->onXhr)
            return;

        $event = "";
        foreach ($this->onXhr as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('xhr.dt', function(e,settings, json, xhr){
            {$event}
        });        
TAG
        );
    }

    public function onStateSaveParams($value): void
    {
        $this->onStateSaveParams[] = $value;
    }

    private function processStateSaveParams()
    {
        if (!$this->onStateSaveParams)
            return;

        $event = "";
        foreach ($this->onStateSaveParams as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('stateSaveParams.dt', function(e,settings, data){
            {$event}
        });        
TAG
        );
    }

    public function onStateLoaded($value): void
    {
        $this->onStateLoaded[] = $value;
    }

    private function processStateLoaded()
    {
        if (!$this->onStateLoaded)
            return;

        $event = "";
        foreach ($this->onStateLoaded as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('stateLoaded.dt', function(e,settings, json){
            {$event}
        });        
TAG
        );
    }

    public function onStateLoadParams($value): void
    {
        $this->onStateLoadParams[] = $value;
    }

    private function processStateLoadParams()
    {
        if (!$this->onStateLoadParams)
            return;

        $event = "";
        foreach ($this->onStateLoadParams as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('stateLoadParams.dt', function(e,settings, json){
            {$event}
        });        
TAG
        );
    }

    public function onSearch($value): void
    {
        $this->onSearch[] = $value;
    }

    private function processSearch()
    {
        if (!$this->onSearch)
            return;

        $event = "";
        foreach ($this->onSearch as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('search.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onProcessing($value): void
    {
        $this->onProcessing[] = $value;
    }

    private function processProcessing()
    {
        if (!$this->onProcessing)
            return;

        $event = "";
        foreach ($this->onProcessing as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('processing.dt', function(e,settings,processing){
            {$event}
        });        
TAG
        );
    }

    public function onPreXhr($value): void
    {
        $this->onPreXhr[] = $value;
    }

    private function processPreXhr()
    {
        if (!$this->onPreXhr)
            return;

        $event = "";
        foreach ($this->onPreXhr as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('preXhr.dt', function(e,settings,json){
            {$event}
        });        
TAG
        );
    }

    public function onPreInit($value): void
    {
        $this->onPreInit[] = $value;
    }

    private function processPreInit()
    {
        if (!$this->onPreInit)
            return;

        $event = "";
        foreach ($this->onPreInit as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('preInit.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onPreDraw($value): void
    {
        $this->onPreDraw[] = $value;
    }

    private function processPreDraw()
    {
        if (!$this->onPreDraw)
            return;

        $event = "";
        foreach ($this->onPreDraw as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('preDraw', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onPage($value): void
    {
        $this->onPage[] = $value;
    }

    private function processPage()
    {
        if (!$this->onPage)
            return;

        $event = "";
        foreach ($this->onPage as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('page.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onOrder($value): void
    {
        $this->onOrder[] = $value;
    }

    private function processOrder()
    {
        if (!$this->onOrder)
            return;

        $event = "";
        foreach ($this->onOrder as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('order.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onLength($value): void
    {
        $this->onLength[] = $value;
    }

    private function processLength()
    {
        if (!$this->onLength)
            return;

        $event = "";
        foreach ($this->onLength as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('length.dt', function(e,settings, len){
            {$event}
        });        
TAG
        );
    }

    public function onInit($value): void
    {
        $this->onInit[] = $value;
    }

    private function processInit()
    {
        if (!$this->onInit)
            return;

        $event = "";
        foreach ($this->onInit as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('init.dt', function(e,settings, json){
            {$event}
        });        
TAG
        );
    }

    public function onError($value): void
    {
        $this->onError[] = $value;
    }

    private function processError()
    {
        if (!$this->onError)
            return;

        $event = "";
        foreach ($this->onError as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('error.dt', function(e,settings, techNote, message){
            {$event}
        });        
TAG
        );
    }

    public function onDraw($value): void
    {
        $this->onDraw[] = $value;
    }

    private function processDraw()
    {
        if (!$this->onDraw)
            return;

        $event = "";
        foreach ($this->onDraw as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('draw', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onDestroy($value): void
    {
        $this->onDestroy[] = $value;
    }

    private function processDestroy()
    {
        if (!$this->onDestroy)
            return;

        $event = "";
        foreach ($this->onDestroy as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('destroy.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    public function onColumnVisibility($value): void
    {
        $this->onColumnVisibility[] = $value;
    }

    private function processColumnVisibility()
    {
        if (!$this->onColumnVisibility)
            return;

        $event = "";
        foreach ($this->onColumnVisibility as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('column-visibility.dt', function(e,settings,column,state, recalc){
            {$event}
        });        
TAG
        );
    }

    public function onColumnSizing($value): void
    {
        $this->onColumnSizing[] = $value;
    }

    private function processColumnSizing()
    {
        if (!$this->onColumnSizing)
            return;

        $event = "";
        foreach ($this->onColumnSizing as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('column-sizing.dt', function(e,settings){
            {$event}
        });        
TAG
        );
    }

    /**
     * @param mixed $value
     */
    public function onSelect($value): void
    {
        $this->onSelect[] = $value;
    }

    /**
     * @param mixed $value
     */
    public function onDeselect($value): void
    {
        $this->onDeselect[] = $value;
    }

    /**
     * @param mixed $value
     */
    public function onSelectItems($value): void
    {
        $this->onSelectItems[] = $value;
    }

    public function onSelectStyle($value): void
    {
        $this->onSelectStyle[] = $value;
    }

    public function onUserSelect($value): void
    {
        $this->onUserSelect[] = $value;
    }

    private function processOnSelect()
    {
        if (!$this->onSelect)
            return;

        $event = "";
        foreach ($this->onSelect as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('select', function(e,dt,type,indexes){
            {$event}
        });        
TAG
);
    }

    private function processOnDeselct()
    {
        if (!$this->onDeselect)
            return;

        $event = "";
        foreach ($this->onDeselect as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('deselect', function(e,dt,type,indexes){
            {$event}
        });        
TAG
        );
    }

    private function processOnSelectItems()
    {
        if (!$this->onSelectItems)
            return;

        $event = "";
        foreach ($this->onSelectItems as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('selectItems', function(e,dt,items){
            {$event}
        });        
TAG
        );
    }

    private function processOnSelectStyle()
    {
        if (!$this->onSelectStyle)
            return;

        $event = "";
        foreach ($this->onSelectStyle as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('selectStyle', function(e,dt,style){
            {$event}
        });        
TAG
        );
    }

    private function processOnUserSelect()
    {
        if (!$this->onUserSelect)
            return;

        $event = "";
        foreach ($this->onUserSelect as $value)
        {
            $event .= $value;
        }

        $this->table->assetsManager->addInlineJsBottom(<<<TAG
        {$this->table->getName()}.on('user-select', function(e, dt, type, cell, originalEvent){
            {$event}
        });        
TAG
        );
    }
}