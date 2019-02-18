<?php

namespace Lib\Forms\Element\Select2;

use Lib\Forms\Element\Select2;

class Options
{
    private $select2;
    public $ajax;
    private $templateSelection;
    private $templateResult;
    private $escapeMarkup;
    private $placeholder;

    private $active = false;

    public function __construct(Select2 $select2)
    {
        $this->select2 = $select2;
        $this->ajax = new Ajax($this->select2);
    }

    /**
     * @return Select2
     */
    public function getSelect2()
    {
        return $this->select2;
    }

    /**
     * @return mixed
     */
    public function getAjax()
    {
        if($this->ajax->getUrl())
            $ajaxRes['url'] = $this->ajax->getUrl();
        if($this->ajax->getDataSrc())
            $ajaxRes['dataSrc'] = $this->ajax->getDataSrc();
        if($this->ajax->getType())
            $ajaxRes['type'] = $this->ajax->getType();
        if($this->ajax->getProcessResults())
            $ajaxRes['processResults'] = $this->ajax->getProcessResults();
        if($this->ajax->getData())
            $ajaxRes['data'] = $this->ajax->getData();

        return $ajaxRes;
    }

    /**
     * @param array $ajax
     */
    public function setAjax( $ajax )
    {
        $this->active = true;
        $this->ajax = $ajax;
    }

    /**
     * @return mixed
     */
    public function getTemplateSelection()
    {
        return $this->templateSelection;
    }

    /**
     * @param mixed $templateSelection
     */
    public function setTemplateSelection( $templateSelection )
    {
        $this->active = true;
        $this->templateSelection = "||".$templateSelection."||";
    }

    /**
     * @return mixed
     */
    public function getTemplateResult()
    {
        return $this->templateResult;
    }

    /**
     * @param mixed $templateResult
     */
    public function setTemplateResult( $templateResult )
    {
        $this->active = true;
        $this->templateResult = "||".$templateResult."||";
    }

    /**
     * @return mixed
     */
    public function getEscapeMarkup()
    {
        return $this->escapeMarkup;
    }

    /**
     * @param mixed $escapeMarkup
     */
    public function setEscapeMarkup( $escapeMarkup )
    {
        $this->active = true;
        $this->escapeMarkup = "||".$escapeMarkup."||";
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     */
    public function setPlaceholder( $placeholder )
    {
        $this->active = true;
        $this->placeholder = $placeholder;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}