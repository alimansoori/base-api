<?php
namespace Lib\Mvc;

use Lib\Authenticates\Auth;
use Lib\Mvc\Model\TEvents;
use Lib\Mvc\Model\TraitSetPosition;
use Lib\Translate\T;
use Lib\Validation;
use Phalcon\Mvc\Model\MessageInterface;
use Phalcon\Mvc\Model\TransactionInterface;
use Phalcon\Text;
use Phalcon\Validation\Validator\Between;


/**
 * @property Helper $helper
 */
abstract class Model extends \Phalcon\Mvc\Model
{
    use TEvents;
    use TraitSetPosition;

    /** @var Validation $validator */
    protected $validator;

    protected $helper;
    /** @var Auth */
    protected $auth;

    protected $dbRef = false;

    protected $modeCreate = false;
    protected $modeUpdate = false;

    public function initialize()
    {
        $this->auth = $this->getDI()->get('auth');

        if( method_exists( $this, 'init' ) )
            $this->init();

        if( $this->getDI()->getShared( 'config' )->database->dbname )
            $this->setSchema( $this->getDI()->getShared( 'config' )->database->dbname );

        $this->helper = $this->getDI()->getShared( 'helper' );

        if( isset( $this->getDI()->getShared( 'config' )->module->database->connection ) && !$this->isDbRef() )
        {
            $this->setConnectionService( $this->getDI()->getShared( 'config' )->module->database->connection );
            $this->setSchema( $this->getDI()->getShared( 'config' )->module->database->dbname );
        }

        if( method_exists( $this, 'relations' ) )
            $this->relations();
    }

    abstract protected function init();

    /**
     * @return bool
     */
    protected function isDbRef()
    {
        return $this->dbRef;
    }

    /**
     * @param bool $dbRef
     */
    protected function setDbRef( $dbRef )
    {
        $this->dbRef = $dbRef;
    }

    /**
     * @return TransactionInterface
     */
    public function getTransaction()
    {
        return $this->_transaction;
    }

    public function hasTransaction()
    {
        if($this->getTransaction() instanceof TransactionInterface)
            return true;

        return false;
    }

    /**
     * @return bool
     */
    public function isModeCreate()
    {
        return $this->modeCreate;
    }

    /**
     * @param bool $modeCreate
     */
    public function setModeCreate( $modeCreate )
    {
        $this->modeCreate = $modeCreate;
    }

    /**
     * @return bool
     */
    public function isModeUpdate()
    {
        return $this->modeUpdate;
    }

    /**
     * @param bool $modeUpdate
     */
    public function setModeUpdate( $modeUpdate )
    {
        $this->modeUpdate = $modeUpdate;
    }

    public function setFieldsByData(array $data)
    {
        if(!is_array($data))
            return;

        foreach ($data as $key => $value)
        {
            $newkey = Text::camelize($key, "_-");
            $methodName = 'set'.$newkey;
            if (method_exists($this, $methodName))
            {
                $this->$methodName($value);
            }
        }
    }

//    public function getMessages()
//    {
//        /** @var MessageInterface $message */
//        foreach (parent::getMessages() as $message) {
//            switch ($message->getType()) {
//                case 'PresenceOf':
//                    if($message->getMessage() == $message->getField() .'is required');
//                        $message->setMessage('The field ' . $message->getField() . ' is mandatory');
//                    break;
//            }
//        }
//
//        return parent::getMessages();
//    }

    public function validation()
    {
        $this->validator = new Validation();

        if(method_exists($this, 'customValidators'))
            $this->customValidators();

        if(method_exists($this, 'mainValidation'))
            $this->mainValidation();

        return $this->validate($this->validator);
    }

    protected function customValidators()
    {
        $this->validatePosition();
    }

    protected function validatePosition()
    {
        if(method_exists($this, 'getPosition'))
        {
            $this->validator->add(
                'position',
                new Between([
                    'minimum' => 1,
                    'maximum' => 100,
                    'allowEmpty' => true,
                    'label' => T::_('position')
                ])
            );
        }
    }

    /* * * * * * * * */
    /*     Events    */
    /* * * * * * * * */

    public function beforeCreate()
    {
        $this->setModeCreate(true);

        if(method_exists($this, 'setCreated'))
            $this->setCreated(time());
    }

    public function beforeUpdate()
    {
        $this->setModeUpdate(true);

        if(method_exists($this, 'setModified'))
            $this->setModified(time());
    }

    public function beforeDelete()
    {

    }


    public function beforeSave()
    {
        if(method_exists($this, 'getPosition') && !($this->getPosition() && is_numeric($this->getPosition())))
        {
            $this->setPositionIfEmpty();
        }
    }

    public function beforeValidation()
    {
        if(method_exists($this, 'getParentId') && !($this->getParentId() && is_numeric($this->getParentId())))
        {
            $this->setParentId(null);
        }
    }

    public function beforeValidationOnCreate()
    {

    }

    public function beforeValidationOnUpdate()
    {

    }

    public function onValidationFails()
    {

    }

    public function prepareSave()
    {

    }

    public function afterSave()
    {
    }

    public function afterCreate()
    {

    }

    public function afterUpdate()
    {

    }

    public function afterDelete()
    {

    }

    public function afterValidation()
    {

    }

    public function afterValidationOnCreate()
    {

    }

    public function afterValidationOnUpdate()
    {

    }
}