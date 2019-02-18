<?php
namespace Lib\Editors\Fields;


use Lib\Messages\Messages;
use Lib\Messages\MessageInterface;

trait TFieldMessages
{
    /** @var Messages */
    protected $messages;

    /**
     * Returns the messages that belongs to the field
     * The field needs to be attached to a editor
     *
     * @return Messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return boolean
     */
    public function hasMessages()
    {
        return count($this->messages) > 0;
    }

    /**
     * Sets the validation messages related to the field
     * @param Messages $messages
     */
    public function setMessages(Messages $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Appends a message to the internal message list
     * @param $message
     * @return TFieldMessages
     */
    public function appendMessage($message)
    {
        $this->messages->appendMessage($message);
        return $this;
    }

}