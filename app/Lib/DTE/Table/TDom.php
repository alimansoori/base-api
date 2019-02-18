<?php
namespace Lib\DTE\Table;


trait TDom
{
    protected function setDefaultDom()
    {
        $this->addOption('dom', 'lfrtip');
    }

    /**
     * @param string $dom
     * @return TDom
     * @example
     * <code>
     *  $table->setDom('lfrtip');
     * </code>
     */
    protected function setDom($dom)
    {
        $this->addOption('dom', $dom);
        return $this;
    }

    /**
     * @return string
     */
    protected function getDom()
    {
        return $this->getOption('dom');
    }
}