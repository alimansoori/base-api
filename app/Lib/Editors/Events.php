<?php
namespace Lib\Editors;


use Lib\DTE\BaseEditor;
use Lib\Mvc\User\Component;

class Events extends Component
{
    private $editor;

    private $close;
    private $create;
    private $displayOrder;
    private $edit;
    private $initCreate;
    private $initEdit;
    private $initRemove;
    private $initSubmit;
    private $open;
    private $postCreate;
    private $postEdit;
    private $postRemove;
    private $postSubmit;
    private $postUpload;
    private $preBlur;
    private $preBlurCancelled;
    private $preClose;
    private $preCloseCancelled;
    private $preCreate;
    private $preEdit;
    private $preOpen;
    private $preOpenCancelled;
    private $preRemove;
    private $preSubmit;
    private $preSubmitCancelled;
    private $preUpload;
    private $preUploadCancelled;
    private $processing;
    private $remove;
    private $setData;
    private $submitComplete;
    private $submitError;
    private $submitSuccess;
    private $submitUnsuccessful;
    private $uploadXhrError;
    private $uploadXhrSuccess;

    public function __construct(Adapter $editor)
    {
        $this->editor = $editor;
    }

    public function process()
    {
        $this->processClose();
        $this->processCreate();
        $this->processDisplayOrder();
        $this->processEdit();
        $this->processInitCreate();
        $this->processInitEdit();
        $this->processInitRemove();
        $this->processInitSubmit();
        $this->processOpen();
        $this->processPostCreate();
        $this->processPostEdit();
        $this->processPostRemove();
        $this->processPostSubmit();
        $this->processPostUpload();
        $this->processPreBlur();
        $this->processPreBlurCancelled();
        $this->processPreClose();
        $this->processPreCloseCancelled();
        $this->processPreCreate();
        $this->processPreEdit();
        $this->processPreOpen();
        $this->processPreOpenCancelled();
        $this->processPreRemove();
        $this->processPreSubmit();
        $this->processPreSubmitCancelled();
        $this->processPreUpload();
        $this->processPreUploadCancelled();
        $this->processProcessing();
        $this->processRemove();
        $this->processSetData();
        $this->processSubmitComplete();
        $this->processSubmitError();
        $this->processSubmitSuccess();
        $this->processSubmitUnsuccessful();
        $this->processUploadXhrError();
        $this->processUploadXhrSuccess();
    }

    /**
     * @param mixed $close
     */
    public function close($close): void
    {
        $this->close[] = $close;
    }

    /**
     * @param mixed $create
     */
    public function create($create): void
    {
        $this->create[] = $create;
    }

    /**
     * @param mixed $displayOrder
     */
    public function displayOrder($displayOrder): void
    {
        $this->displayOrder[] = $displayOrder;
    }

    /**
     * @param mixed $edit
     */
    public function edit($edit): void
    {
        $this->edit[] = $edit;
    }

    /**
     * @param mixed $initCreate
     */
    public function initCreate($initCreate): void
    {
        $this->initCreate[] = $initCreate;
    }

    /**
     * @param mixed $initEdit
     */
    public function initEdit($initEdit): void
    {
        $this->initEdit[] = $initEdit;
    }

    /**
     * @param mixed $initRemove
     */
    public function initRemove($initRemove): void
    {
        $this->initRemove[] = $initRemove;
    }

    /**
     * @param mixed $initSubmit
     */
    public function initSubmit($initSubmit): void
    {
        $this->initSubmit[] = $initSubmit;
    }

    /**
     * @param mixed $open
     */
    public function open($open): void
    {
        $this->open[] = $open;
    }

    /**
     * @param mixed $postCreate
     */
    public function postCreate($postCreate): void
    {
        $this->postCreate[] = $postCreate;
    }

    /**
     * @param mixed $postEdit
     */
    public function postEdit($postEdit): void
    {
        $this->postEdit[] = $postEdit;
    }

    /**
     * @param mixed $postRemove
     */
    public function postRemove($postRemove): void
    {
        $this->postRemove[] = $postRemove;
    }

    /**
     * @param mixed $postSubmit
     */
    public function postSubmit($postSubmit): void
    {
        $this->postSubmit[] = $postSubmit;
    }

    /**
     * @param mixed $postUpload
     */
    public function postUpload($postUpload): void
    {
        $this->postUpload[] = $postUpload;
    }

    /**
     * @param mixed $preBlur
     */
    public function preBlur($preBlur): void
    {
        $this->preBlur[] = $preBlur;
    }

    /**
     * @param mixed $preBlurCancelled
     */
    public function preBlurCancelled($preBlurCancelled): void
    {
        $this->preBlurCancelled[] = $preBlurCancelled;
    }

    /**
     * @param mixed $preClose
     */
    public function preClose($preClose): void
    {
        $this->preClose[] = $preClose;
    }

    /**
     * @param mixed $preCloseCancelled
     */
    public function preCloseCancelled($preCloseCancelled): void
    {
        $this->preCloseCancelled[] = $preCloseCancelled;
    }

    /**
     * @param mixed $preCreate
     */
    public function preCreate($preCreate): void
    {
        $this->preCreate[] = $preCreate;
    }

    /**
     * @param mixed $preEdit
     */
    public function preEdit($preEdit): void
    {
        $this->preEdit[] = $preEdit;
    }

    /**
     * @param mixed $preOpen
     */
    public function preOpen($preOpen): void
    {
        $this->preOpen[] = $preOpen;
    }

    /**
     * @param mixed $preOpenCancelled
     */
    public function preOpenCancelled($preOpenCancelled): void
    {
        $this->preOpenCancelled[] = $preOpenCancelled;
    }

    /**
     * @param mixed $preRemove
     */
    public function preRemove($preRemove): void
    {
        $this->preRemove[] = $preRemove;
    }

    /**
     * @param mixed $preSubmit
     */
    public function preSubmit($preSubmit): void
    {
        $this->preSubmit[] = $preSubmit;
    }

    /**
     * @param mixed $preSubmitCancelled
     */
    public function preSubmitCancelled($preSubmitCancelled): void
    {
        $this->preSubmitCancelled[] = $preSubmitCancelled;
    }

    /**
     * @param mixed $preUpload
     */
    public function preUpload($preUpload): void
    {
        $this->preUpload[] = $preUpload;
    }

    /**
     * @param mixed $preUploadCancelled
     */
    public function preUploadCancelled($preUploadCancelled): void
    {
        $this->preUploadCancelled[] = $preUploadCancelled;
    }

    /**
     * @param mixed $processing
     */
    public function processing($processing): void
    {
        $this->processing[] = $processing;
    }

    /**
     * @param mixed $remove
     */
    public function remove($remove): void
    {
        $this->remove[] = $remove;
    }

    /**
     * @param $setData
     */
    public function setData($setData): void
    {
        $this->setData[] = $setData;
    }

    /**
     * @param mixed $submitComplete
     */
    public function submitComplete($submitComplete): void
    {
        $this->submitComplete[] = $submitComplete;
    }

    /**
     * @param mixed $submitError
     */
    public function submitError($submitError): void
    {
        $this->submitError[] = $submitError;
    }

    /**
     * @param mixed $submitSuccess
     */
    public function submitSuccess($submitSuccess): void
    {
        $this->submitSuccess[] = $submitSuccess;
    }

    /**
     * @param mixed $submitUnsuccessful
     */
    public function submitUnsuccessful($submitUnsuccessful): void
    {
        $this->submitUnsuccessful[] = $submitUnsuccessful;
    }

    /**
     * @param mixed $uploadXhrError
     */
    public function uploadXhrError($uploadXhrError): void
    {
        $this->uploadXhrError[] = $uploadXhrError;
    }

    /**
     * @param mixed $uploadXhrSuccess
     */
    public function uploadXhrSuccess($uploadXhrSuccess): void
    {
        $this->uploadXhrSuccess[] = $uploadXhrSuccess;
    }

    private function processClose()
    {
        if (!$this->close)
            return;

        $event = "";
        foreach ($this->close as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('close', function(e){
            {$event}
        });        
TAG
);
    }

    private function processCreate()
    {
        if (!$this->create)
            return;

        $event = "";
        foreach ($this->create as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('create', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processDisplayOrder()
    {
        if (!$this->displayOrder)
            return;

        $event = "";
        foreach ($this->displayOrder as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('open displayOrder', function(e,mode,action,form){
            {$event}
        });        
TAG
        );
    }

    private function processEdit()
    {
        if (!$this->edit)
            return;

        $event = "";
        foreach ($this->edit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('edit', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processInitCreate()
    {
        if (!$this->initCreate)
            return;

        $event = "";
        foreach ($this->initCreate as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('initCreate', function(e){
            {$event}
        });        
TAG
        );
    }

    private function processInitEdit()
    {
        if (!$this->initEdit)
            return;

        $event = "";
        foreach ($this->initEdit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('initEdit', function(e,node,data,items,type){
            {$event}
        });        
TAG
        );
    }

    private function processInitRemove()
    {
        if (!$this->initRemove)
            return;

        $event = "";
        foreach ($this->initRemove as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('initRemove', function(e,node,data,items){
            {$event}
        });        
TAG
        );
    }

    private function processInitSubmit()
    {
        if (!$this->initSubmit)
            return;

        $event = "";
        foreach ($this->initSubmit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('initSubmit', function(e,action){
            {$event}
        });        
TAG
        );
    }

    private function processOpen()
    {
        if (!$this->initSubmit)
            return;

        $event = "";
        foreach ($this->initSubmit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('open', function(e,mode,action){
            {$event}
        });        
TAG
        );
    }

    private function processPostCreate()
    {
        if (!$this->postCreate)
            return;

        $event = "";
        foreach ($this->postCreate as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('postCreate', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processPostEdit()
    {
        if (!$this->postEdit)
            return;

        $event = "";
        foreach ($this->postEdit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('postEdit', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processPostRemove()
    {
        if (!$this->postRemove)
            return;

        $event = "";
        foreach ($this->postRemove as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('postRemove', function(e,json,ids){
            {$event}
        });        
TAG
        );
    }

    private function processPostSubmit()
    {
        if (!$this->postSubmit)
            return;

        $event = "";
        foreach ($this->postSubmit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('postSubmit', function(e,json,data,action,xhr){
            {$event}
        });        
TAG
        );
    }

    private function processPostUpload()
    {
        if (!$this->postUpload)
            return;

        $event = "";
        foreach ($this->postUpload as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('postUpload', function(e,fieldName,fieldValue){
            {$event}
        });        
TAG
        );
    }

    private function processPreBlur()
    {
        if (!$this->preBlur)
            return;

        $event = "";
        foreach ($this->preBlur as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preBlur', function(e){
            {$event}
        });        
TAG
        );
    }

    private function processPreBlurCancelled()
    {
        if (!$this->preBlurCancelled)
            return;

        $event = "";
        foreach ($this->preBlurCancelled as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preBlurCancelled', function(e){
            {$event}
        });        
TAG
        );
    }

    private function processPreClose()
    {
        if (!$this->preClose)
            return;

        $event = "";
        foreach ($this->preClose as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preClose', function(e){
            {$event}
        });        
TAG
        );
    }

    private function processPreCloseCancelled()
    {
        if (!$this->preBlurCancelled)
            return;

        $event = "";
        foreach ($this->preBlurCancelled as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preBlurCancelled', function(e){
            {$event}
        });        
TAG
        );
    }

    private function processPreCreate()
    {
        if (!$this->preCreate)
            return;

        $event = "";
        foreach ($this->preCreate as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preCreate', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processPreEdit()
    {
        if (!$this->preEdit)
            return;

        $event = "";
        foreach ($this->preEdit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preEdit', function(e,json,data,id){
            {$event}
        });        
TAG
        );
    }

    private function processPreOpen()
    {
        if (!$this->preOpen)
            return;

        $event = "";
        foreach ($this->preOpen as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preOpen', function(e,mode,action){
            {$event}
        });        
TAG
        );
    }

    private function processPreOpenCancelled()
    {
        if (!$this->preOpenCancelled)
            return;

        $event = "";
        foreach ($this->preOpenCancelled as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preOpenCancelled', function(e,mode,action){
            {$event}
        });        
TAG
        );
    }

    private function processPreRemove()
    {
        if (!$this->preRemove)
            return;

        $event = "";
        foreach ($this->preRemove as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preRemove', function(e,json,ids){
            {$event}
        });        
TAG
        );
    }

    private function processPreSubmit()
    {
        if (!$this->preSubmit)
            return;

        $event = "";
        foreach ($this->preSubmit as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preSubmit', function(e,data,action){
            {$event}
        });        
TAG
        );
    }

    private function processPreSubmitCancelled()
    {
        if (!$this->preSubmitCancelled)
            return;

        $event = "";
        foreach ($this->preSubmitCancelled as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preSubmitCancelled', function(e,data,action){
            {$event}
        });        
TAG
        );
    }

    private function processPreUpload()
    {
        if (!$this->preUpload)
            return;

        $event = "";
        foreach ($this->preUpload as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preUpload', function(e,fieldName, file, ajaxData){
            {$event}
        });        
TAG
        );
    }

    private function processPreUploadCancelled()
    {
        if (!$this->preUploadCancelled)
            return;

        $event = "";
        foreach ($this->preUploadCancelled as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('preUploadCancelled', function(e,fieldName, file, ajaxData){
            {$event}
        });        
TAG
        );
    }

    private function processProcessing()
    {
        if (!$this->processing)
            return;

        $event = "";
        foreach ($this->processing as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('processing', function(e,processing){
            {$event}
        });        
TAG
        );
    }

    private function processRemove()
    {
        if (!$this->remove)
            return;

        $event = "";
        foreach ($this->remove as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('remove', function(e,json,ids){
            {$event}
        });        
TAG
        );
    }

    private function processSetData()
    {
        if (!$this->setData)
            return;

        $event = "";
        foreach ($this->setData as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('setData', function(e,json,data,action){
            {$event}
        });        
TAG
        );
    }

    private function processSubmitComplete()
    {
        if (!$this->submitComplete)
            return;

        $event = "";
        foreach ($this->submitComplete as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('submitComplete', function(e,json,data,action){
            {$event}
        });        
TAG
        );
    }

    private function processSubmitError()
    {
        if (!$this->submitError)
            return;

        $event = "";
        foreach ($this->submitError as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('submitError', function(e,xhr, err, thrown, data){
            {$event}
        });        
TAG
        );
    }

    private function processSubmitSuccess()
    {
        if (!$this->submitSuccess)
            return;

        $event = "";
        foreach ($this->submitSuccess as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('submitSuccess', function(e,json,data,action){
            {$event}
        });        
TAG
        );
    }

    private function processSubmitUnsuccessful()
    {
        if (!$this->submitUnsuccessful)
            return;

        $event = "";
        foreach ($this->submitUnsuccessful as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('submitUnsuccessful', function(e,json,data){
            {$event}
        });        
TAG
        );
    }

    private function processUploadXhrError()
    {
        if (!$this->uploadXhrError)
            return;

        $event = "";
        foreach ($this->uploadXhrError as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('uploadXhrError', function(e,fieldName, xhr){
            {$event}
        });        
TAG
        );
    }

    private function processUploadXhrSuccess()
    {
        if (!$this->uploadXhrSuccess)
            return;

        $event = "";
        foreach ($this->uploadXhrSuccess as $value)
        {
            $event .= $value;
        }

        $this->editor->assetsManager->addInlineJsBottom(<<<TAG
        {$this->editor->getName()}.on('uploadXhrSuccess', function(e,fieldName, json){
            {$event}
        });        
TAG
        );
    }
}