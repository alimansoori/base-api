<?php
namespace Lib\DTE;


use Lib\Common\Strings;
use Lib\DTE\Ajax\AjaxCommon;

class AjaxInputData extends AjaxCommon
{
    /** @var string */
    protected $success;
    protected $entity;

    public function __construct($entity=null)
    {
        parent::__construct();

        if(method_exists($entity, 'getName'))
        {
            $this->data['action'] = 'initData';
            $this->data['name'] = $entity->getName();
        }
    }

    public function toArray()
    {
        $out = parent::toArray();

        if(is_array($this->data))
            $out['data'] = $this->getData(true);
        if($this->success)
            $out['success'] = $this->success;

        return $out;
    }

    /**
     * @return string
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param string $success
     */
    public function setSuccess( $success )
    {
        $this->success = Strings::multilineToSingleline("||function(json){ {$success} }||");
    }
}