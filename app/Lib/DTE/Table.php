<?php
namespace Lib\DTE;

use Lib\DTE\Asset\Assets;
use Lib\DTE\Table\Ajax;
use Lib\DTE\Table\RowGroup;
use Lib\DTE\Table\Select;
use Lib\DTE\Table\TButtons;
use Lib\DTE\Table\TColumns;
use Lib\DTE\Table\TDataAjax;
use Lib\DTE\Table\TDom;
use Lib\DTE\Table\TLanguage;
use Lib\DTE\Table\TOptions;
use Lib\DTE\Table\TProcess;
use Lib\DTE\Table\TRender;

abstract class Table extends BaseTable
{
    /** @var RowGroup $rowGroup */
    public $rowGroup;

    /** @var Ajax */
    public $ajax;

    /** @var Select */
    public $select;

    use TOptions;
    use TDom;
    use TLanguage;
    use TButtons;
    use TColumns;
    use TProcess;
    use TRender;
    use TDataAjax;

    public function __construct( $name )
    {
        parent::__construct($name);
        $this->translate();
        $this->setDefaultDom();

        $this->assetsManager = new Assets();

        $this->ajax     = new Ajax($this);
        $this->select   = new Select($this);
        $this->rowGroup = new RowGroup($this);
    }

    abstract public function init();

    abstract public function initAjax();

    public function setCustomAssets()
    {
        $this->assetsManager->addJs( 'assets/datatables.net/js/jquery.dataTables.min.js' );
        $this->assetsManager->addCss( 'assets/datatables.net-dt/css/jquery.dataTables.min.css' );
        $this->assetsManager->addCss('assets/datatables.net-responsive-dt/css/responsive.dataTables.min.css');
        $this->assetsManager->addJs('assets/datatables.net-responsive/js/dataTables.responsive.min.js');
    }
}