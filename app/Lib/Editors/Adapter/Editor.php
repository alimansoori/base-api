<?php
namespace Lib\Editors\Adapter;


use Lib\Assets\Inline;
use Lib\Assets\Resource;
use Lib\Editors\Adapter;
use Lib\Editors\Ajax\AjaxCreate;
use Lib\Editors\Ajax\AjaxEdit;
use Lib\Editors\Ajax\AjaxRemove;

abstract class Editor extends Adapter
{
    public function __construct(string $name, $hierarchy = false)
    {
        parent::__construct($name);

        if ($hierarchy)
        {
            $this->ajaxCreate = new AjaxCreate($this, true);
            $this->ajaxEdit   = new AjaxEdit($this, true);
            $this->ajaxRemove = new AjaxRemove($this, true);
        }
    }

    public function render(): string
    {
        $this->beforeRender();

        return '';
    }

    public function processAssets()
    {
        $this->assetsManager->addInlineJsTop("var ". $this->getName(). ";");

        if($this->assetsManager->getCss() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $css */
            foreach($this->assetsManager->getCss()->getResources() as $css)
                $this->getTable()->assetsManager->addCss($css->getPath(), $css->getLocal(), $css->getFilter(), $css->getAttributes());

            /** @var Inline $css */
            foreach($this->assetsManager->getCss()->getCodes() as $css)
                $this->getTable()->assetsManager->addInlineCss($css->getContent(), $css->getFilter(), $css->getAttributes());
        }

        if($this->assetsManager->getJs() instanceof \Phalcon\Assets\Collection)
        {
            /** @var Resource $js */
            foreach($this->assetsManager->getJs()->getResources() as $js)
                $this->getTable()->assetsManager->addJs($js->getPath(), $js->getLocal(), $js->getFilter(), $js->getAttributes());

            /** @var Inline $js */
            foreach($this->assetsManager->getJs()->getCodes() as $js)
                $this->getTable()->assetsManager->addInlineJs($js->getContent(), $js->getFilter(), $js->getAttributes());
        }

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $this->getTable()->assetsManager->addInlineJsTop($content->getContent());

        $editor = "{$this->getName()} = new $.fn.dataTable.Editor( ";
        $editor .= json_encode($this->options);
        // process options to json encode
        $editor .= " );";

        $this->getTable()->assetsManager->addInlineJsMain($editor);

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $this->getTable()->assetsManager->addInlineJsMain($content->getContent());

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $this->getTable()->assetsManager->addInlineJsBottom($content->getContent());

        $this->getTable()->assetsManager->addCss('dt/css/style.dataTable.css');
    }

    public function beforeRender(): void
    {
        // TODO: Implement beforeRender() method.
    }
}