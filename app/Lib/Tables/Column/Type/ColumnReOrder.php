<?php
namespace Lib\Tables\Column\Type;


use Lib\Tables\Column;

class ColumnReOrder extends Column
{
    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->setClassName('reorder');
    }

    public function init()
    {
        parent::init();

        $this->getTable()->assetsManager->addJs('assets/datatables.net-rowreorder/js/dataTables.rowReorder.min.js');
        $this->getTable()->assetsManager->addCss('assets/datatables.net-rowreorder-dt/css/rowReorder.dataTables.min.css');

        if($this->getTable() && $this->getEditor())
        {
            $editorName = $this->getEditor()->getName();
            $tableName = $this->getTable()->getName();

            $this->getTable()->addOption('rowReorder', [
                'dataSrc' => $this->data,
                'editor' => "||".$editorName."||"
            ]);

            $this->getTable()->assetsManager->addInlineJsBottom( /** @lang JavaScript */
                "
{$editorName}
        .on( 'postCreate postRemove', function () {
            {$tableName}.ajax.reload( null, false );
        } )
        .on( 'initCreate', function () {
            {$editorName}.field( '{$this->getData()}' ).enable();
        } )
        .on( 'initEdit', function () {
            {$editorName}.field( '{$this->getData()}' ).disable();
        } );
");
        }
    }

}