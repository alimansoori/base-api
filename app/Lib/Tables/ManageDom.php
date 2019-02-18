<?php
namespace Lib\Tables;


trait ManageDom
{
    public function setDom(string $dom): void
    {
        $this->addOption('dom', $dom);
    }

    public function getDom(): string
    {
        return $this->getOption('dom');
    }
}