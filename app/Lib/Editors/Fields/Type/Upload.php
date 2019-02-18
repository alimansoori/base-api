<?php
namespace Lib\Editors\Fields\Type;


use Lib\Common\Strings;
use Lib\Editors\Fields\Field;
use Lib\Editors\Fields\Type\Text\TTextOptions;
use Lib\Translate\T;

class Upload extends Field
{
    use TTextOptions;

    public function __construct( $name , $many = false)
    {
        if ($many === true)
        {
            $name = $name. '[]';
        }
        parent::__construct( $name );
        $this->setType('upload');
        if ($many === true)
        {
            $this->setType('uploadMany');
        }

        $this->setNoFileText(T::_('no_file_upload'));
        $this->setClearText(T::_('clear_upload'));
        $this->setDragDropText(T::_('drag_drop_upload'));
        $this->setUploadText(T::_('upload_text'));
        $this->setProcessingText(T::_('process_text_upload'));
        $this->setFileReadText(T::_('file_read_text_upload'));
    }

    public function toArray()
    {
        $output = parent::toArray();

        if($this->ajax)
            $output['ajax'] = $this->getAjax();
        if($this->ajaxData)
            $output['ajaxData'] = $this->getAjaxData();
        if($this->clearText)
            $output['clearText'] = $this->getClearText();

        if($this->display)
            $output['display'] = Strings::multilineToSingleline("||function(file_id){".$this->getDisplay()."}||");
        else
            $output['display'] = Strings::multilineToSingleline("||function(file_id){return '<img src=\"'+{$this->getEditor()->getName()}.file('files', file_id).web_path+'\"/>';}||");

        if($this->dragDrop === false)
            $output['dragDrop'] = false;
        if($this->dragDropText)
            $output['dragDropText'] = $this->getDragDropText();
        if($this->fileReadText)
            $output['fileReadText'] = $this->getFileReadText();
        if($this->noFileText)
            $output['noFileText'] = $this->getNoFileText();
        if($this->processingText)
            $output['processingText'] = $this->getProcessingText();
        if($this->uploadText)
            $output['uploadText'] = $this->getUploadText();

        return $output;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * */
    /*    Options
    /* * * * * * * * * * * * * * * * * * * * * * * */

    private $ajax;
    private $ajaxData;
    /** @var string|null */
    private $clearText;
    private $display;
    private $dragDrop = true;
    /** @var string|null */
    private $dragDropText;
    /** @var string|null */
    private $fileReadText;
    /** @var string|null */
    private $noFileText;
    /** @var string|null */
    private $processingText;
    /** @var string|null */
    private $uploadText;

    /**
     * @return mixed
     */
    public function getAjax()
    {
        return $this->ajax;
    }

    /**
     * @param array $ajax
     */
    public function setAjax(array $ajax): void
    {
        $this->ajax = $ajax;
    }

    /**
     * @return mixed
     */
    public function getAjaxData()
    {
        return $this->ajaxData;
    }

    /**
     * @param mixed $ajaxData
     */
    public function setAjaxData($ajaxData): void
    {
        $this->ajaxData = $ajaxData;
    }

    /**
     * @return string|null
     */
    public function getClearText(): ?string
    {
        return $this->clearText;
    }

    /**
     * @param string|null $clearText
     */
    public function setClearText(?string $clearText): void
    {
        $this->clearText = $clearText;
    }

    /**
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param mixed $display
     */
    public function setDisplay($display): void
    {
        $this->display = $display;
    }

    /**
     * @return bool
     */
    public function isDragDrop(): bool
    {
        return $this->dragDrop;
    }

    /**
     * @param bool $dragDrop
     */
    public function setDragDrop(bool $dragDrop): void
    {
        $this->dragDrop = $dragDrop;
    }

    /**
     * @return string|null
     */
    public function getDragDropText(): ?string
    {
        return $this->dragDropText;
    }

    /**
     * @param string|null $dragDropText
     */
    public function setDragDropText(?string $dragDropText): void
    {
        $this->dragDropText = $dragDropText;
    }

    /**
     * @return string|null
     */
    public function getFileReadText(): ?string
    {
        return $this->fileReadText;
    }

    /**
     * @param string|null $fileReadText
     */
    public function setFileReadText(?string $fileReadText): void
    {
        $this->fileReadText = $fileReadText;
    }

    /**
     * @return string|null
     */
    public function getNoFileText(): ?string
    {
        return $this->noFileText;
    }

    /**
     * @param string|null $noFileText
     */
    public function setNoFileText(?string $noFileText): void
    {
        $this->noFileText = $noFileText;
    }

    /**
     * @return string|null
     */
    public function getProcessingText(): ?string
    {
        return $this->processingText;
    }

    /**
     * @param string|null $processingText
     */
    public function setProcessingText(?string $processingText): void
    {
        $this->processingText = $processingText;
    }

    /**
     * @return string|null
     */
    public function getUploadText(): ?string
    {
        return $this->uploadText;
    }

    /**
     * @param string|null $uploadText
     */
    public function setUploadText(?string $uploadText): void
    {
        $this->uploadText = $uploadText;
    }
}