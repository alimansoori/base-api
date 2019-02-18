<?php
namespace Lib\DTE\Editor;

use Lib\DTE\Editor\Fields\Field;
use Lib\Messages\Message;
use Lib\Messages\Messages;
use Lib\Exception;
use Phalcon\Validation\MessageInterface;
use phpDocumentor\Reflection\Types\This;

trait TMessages
{
    /** @var Messages */
    protected $messages;

    /**
     * @return Messages
     */
    public function getMessages()
    {
        $messages = $this->messages;

        if(is_object($messages) && $messages instanceof Messages)
        {
            return $messages;
        }

        $this->messages = new Messages();

        return $this->messages;
    }

    /**
     * @param string $name
     * @return Messages
     */
    public function getMessagesFor($name)
    {
        if($this->hasField($name))
        {
            /** @var Field $field */
            $field = $this->getField($name);
            return $field->getMessages();
        }

        return new Messages();
    }

    public function hasMessagesFor($name)
    {
        return $this->getMessagesFor($name)->count() > 0;
    }

    /**
     * Appends a message to the group
     * @param MessageInterface $message
     * @param string $field
     * @param string $type
     * @param int $code
     * @return bool
     */
    public function appendMessage($message, $field='', $type='', $code=0)
    {
        if(is_string($message))
        {
            $message = new Message($message, $field, $type, $code);
        }

        if(!is_object($this->getMessages()) || !$this->getMessages() instanceof Messages)
            return false;

        $this->getMessages()->appendMessage($message);
    }

    public function appendMessages($messages)
    {
        if($messages instanceof Messages || is_array($messages))
        {
            $this->getMessages()->appendMessages($messages);
            return;
        }

        throw new Exception('messages does not array of MessagesInterface');
    }
}