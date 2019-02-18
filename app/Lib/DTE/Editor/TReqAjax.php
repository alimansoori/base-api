<?php
namespace Lib\DTE\Editor;
use Lib\Common\Strings;
use Lib\Mvc\View;
use Lib\Translate\T;
use Phalcon\Http\RequestInterface;

/**
 * @property RequestInterface request
 * @property View             view
 */
trait TReqAjax
{
    protected $data = [];
    protected $dataAfterValidate = [];

    public function processData()
    {
        if(
            $this->request->isAjax() &&
            $this->request->getPost('action') &&
            $this->request->getPost('name') &&
            $this->request->getPost('name') === $this->getName()
        )
        {
            $this->data = [];
            $this->view->disable();
            if(is_array($this->request->getPost('data')))
                $this->postData = $this->request->getPost('data');

            if($this->request->getPost('action') == 'create')
            {
                $this->operationMade = self::OP_CREATE;
//                $this->getStatus()->setCreate(true);
                if($this->validateDataBeforeCreate())
                    $this->createAction();
            }
            elseif($this->request->getPost('action') == 'edit')
            {
                $this->operationMade = self::OP_EDIT;
//                $this->getStatus()->setEdit(true);
                if($this->validateDataBeforeUpdate())
                {
                    $this->editAction();
                }
            }
            elseif($this->request->getPost('action') == 'remove')
            {
                $this->operationMade = self::OP_REMOVE;
//                $this->getStatus()->setRemove(true);
                $this->setDataAfterValidate($this->getPostData());
                $this->removeAction();
            }
        }
    }

    /** @return mixed */
    public function getData()
    {
//        $row = [];
//        foreach($this->data as $data)
//        {
//            $col = [];
//            foreach($data as $key=>$datum)
//            {
//                if(Strings::IsStartBy($datum, '__'))
//                {
//                    $translate = substr($datum, 2);
//                    $col[$key] = T::_($translate);
//                }
//                else
//                {
//                    $col[$key] = $datum;
//                }
//            }
//
//            $row[] = $col;
//        }

        return $this->data;
    }

    /** @param array $data */
    public function setData( $data ) { $this->data = $data; }

    public function addDatum($data) { $this->data[] = $data; }

    public function addData($data)
    {
        $this->data = array_merge($this->data, [$data]);
    }

    protected function validateDataBeforeCreate()
    {
        if(!is_array($this->getPostData()))
        {
            $this->setError('An error has occurred => 1');
            return false;
        }

        $dataAfterValidate = [];
        foreach($this->getPostData() as $key=>$data)
        {
            if(!is_array($data))
            {
                $this->setError('An error has occurred => 2');
                return false;
            }

            if(!$this->isValid($data))
                return false;

            $dataAfterValidate[$key] = $this->dataAfterValidate;
        }

        $this->dataAfterValidate = $dataAfterValidate;

        return true;
    }

    protected function validateDataBeforeUpdate()
    {
        if(!is_array($this->getPostData()))
        {
            $this->setError('An error has occurred => 1');
            return false;
        }

        $dataAfterValidate = [];
        foreach($this->getPostData() as $key=>$data)
        {
            if(!is_array($data))
            {
                $this->setError('An error has occurred => 2');
                return false;
            }

            if(!$this->isValid($data))
                return false;

            $dataAfterValidate[$key] = $this->dataAfterValidate;
        }

        $this->dataAfterValidate = $dataAfterValidate;

        return true;
    }

    /** @return array */
    public function getDataAfterValidate()
    {
        return $this->dataAfterValidate;
    }

    /** @param array $dataAfterValidate */
    public function setDataAfterValidate( $dataAfterValidate ) { $this->dataAfterValidate = $dataAfterValidate; }

    public function addDataAfterValidate( $name, $data ) { $this->dataAfterValidate[$name] = $data; }
}