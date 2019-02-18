<?php
namespace Lib\Tables;

use Lib\Assets\Inline;
use Lib\Assets\Manager;
use Lib\Assets\Resource;
use Lib\Common\Strings;
use Lib\DTE\Asset\Assets;
use Lib\Editors\Adapter\Editor;
use Lib\Tables\Buttons\Button;

/**
 * @property AjaxInterface ajax
 * @property Events        events
 * @property Assets        assetsManager
 * @property Manager       assets
 */
trait ManageProcess
{
    public function beforeProcess(): void
    {
        $this->initEditors();
        $this->init();
        $this->ajax->process();
        $this->processColumns();
        $this->processButtons();
        $this->processEditors();
    }

    public function processEvents()
    {
        $this->events->process();
    }

    public function process(bool $status=true)
    {
        if ($status == false)
        {
            $this->beforeProcess();
            return $this;
        }

        $this->setCustomAssets();
        $this->beforeProcess();
        $this->processExtensionAssets();
        $this->processEvents();
        $this->processAssets();

        return $this;
    }

    private function processButtons(): void
    {
        $this->initButtons();

        /** @var Button $button */
        foreach($this->buttons as $button)
        {
            $button->init();
            $this->options['buttons'][] = $button->toArray();
        }
    }

    private function processEditors()
    {
        /** @var Editor $editor */
        foreach($this->getEditors() as $editor)
        {
            $editor->process();
        }
    }

    protected function processAssets()
    {
        $table = '';
        if($this->assetsManager->getCss() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $css */
            foreach($this->assetsManager->getCss()->getResources() as $css)
                $this->assets->collection($this->getName())->addCss($css->getPath(), $css->getLocal(), $css->getFilter(), $css->getAttributes());

            /** @var Inline $css */
            foreach($this->assetsManager->getCss()->getCodes() as $css)
                $this->assets->collection($this->getName())->addInlineCss($css->getContent(), $css->getFilter(), $css->getAttributes());

        }

        if($this->assetsManager->getJs() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $js */
            foreach($this->assetsManager->getJs()->getResources() as $js)
                $this->assets->collection($this->getName())->addJs($js->getPath(), $js->getLocal(), $js->getFilter(), $js->getAttributes());

            /** @var Inline $js */
            foreach($this->assetsManager->getJs()->getCodes() as $js)
                $this->assets->collection($this->getName())->addInlineJs($js->getContent(), $js->getFilter(), $js->getAttributes());
        }

        if($this->getName())
            $table .= "var ". $this->getName(). ";";

        $table .= "$(document).ready(function() {";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $table .= $content->getContent();

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $table .= $content->getContent();

        $table .= "{$this->getName()} = $('#{$this->getName()}').DataTable( ";
        $table .= json_encode($this->options);
        $table .= ");";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $table .= $content->getContent();

        $table .= "} );";

        $this->assets->collection($this->getName())->addInlineJs(
            Strings::clean($table)
        );
    }

    protected function setCustomAssets()
    {
        $this->assetsManager->addJs( 'assets/datatables.net/js/jquery.dataTables.min.js' );
        $this->assetsManager->addCss( 'assets/datatables.net-dt/css/jquery.dataTables.min.css' );
    }

    protected function processExtensionAssets()
    {
        if ($this->isOption('fixedColumns'))
        {
            $this->assetsManager->addJs( 'assets/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js' );
            $this->assetsManager->addCss( 'assets/datatables.net-fixedcolumns-dt/css/fixedColumns.dataTables.min.css' );
            $this->assetsManager->addInlineCss( "th, td { white-space: nowrap; } div.dataTables_wrapper { margin: 0 auto; }" );
        }

        if ($this->isOption('responsive'))
        {
            $this->assetsManager->addJs( 'assets/datatables.net-responsive/js/dataTables.responsive.min.js' );
            $this->assetsManager->addCss( 'assets/datatables.net-responsive-dt/css/responsive.dataTables.min.css' );
        }

        if ($this->isOption('select'))
        {
            $this->assetsManager->addJs( 'assets/datatables.net-select/js/dataTables.select.min.js' );
            $this->assetsManager->addCss( 'assets/datatables.net-select-dt/css/select.dataTables.min.css' );
        }

    }
}