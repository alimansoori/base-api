<?php
namespace Lib\Editors\Adapter;


use Lib\Assets\Inline;
use Lib\Assets\Resource;
use Lib\Common\Strings;
use Lib\Editors\Adapter;
use Phalcon\Text;

abstract class StandaloneEditor extends Adapter
{
    public function render(): string
    {
        $this->beforeRender();
        return "";
    }

    public function processAssets()
    {
        $editor = '';

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

        $editor .= "$(document).ready(function() {";

        $editor .= "var ". $this->getName(). ";";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsTop() as $content)
            $editor .= $content->getContent();

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsMain() as $content)
            $editor .= $content->getContent();

        $editor .= "{$this->getName()} = new $.fn.dataTable.Editor( ";
        $editor .= json_encode($this->options);
        // process options to json encode
        $editor .= " );";

        /** @var Inline $content */
        foreach($this->assetsManager->getInlineJsBottom() as $content)
            $editor .= $content->getContent();

        $editor .= "} );";
        $this->assets->collection($this->getName())->addInlineJs(Strings::clean($editor), true, ['cache'=> false]);
        $this->assets->collection($this->getName())->addCss('dt/css/style.dataTable.css');
    }

    public function beforeRender(): void
    {
        /** @var Resource $resource */
        foreach ($this->assets->collection($this->getName())->getResources() as $resource)
        {
            if ($resource->getType() == 'css' || $resource->getType() == 'js') {
                $this->assetsCollection->{'add'. Text::camelize($resource->getType())}(
                    $resource->getPath(),
                    $resource->getLocal(),
                    $resource->getFilter(),
                    $resource->getAttributes()
                );
            }
        }
        /** @var Inline $inline */
        foreach ($this->assets->collection($this->getName())->getCodes() as $inline)
        {
            if ($inline->getType() == 'css' || $inline->getType() == 'js') {
                $this->assetsCollection->{'addInline'.Text::camelize($inline->getType())}(
                    $inline->getContent(),
                    $inline->getFilter(),
                    $inline->getAttributes()
                );
            }
        }
    }

    public function setCustomAssets()
    {
        $this->assetsManager->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsManager->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        parent::setCustomAssets();
    }
}