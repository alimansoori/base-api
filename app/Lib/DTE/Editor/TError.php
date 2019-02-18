<?php
namespace Lib\DTE\Editor;


use Lib\Messages\Message;

trait TError
{
    protected $error;

    public function getFieldErrors()
    {
        $errors = [];
        /** @var Message $message */
        foreach($this->getMessages() as $message)
        {
            if(!$this->hasField($message->getField()))
            {
                $this->setError($message->getMessage());
                continue;
            }

            $errors[] = [
                'name' => $message->getField(),
                'status' => $message->getMessage()
            ];
        }
        return $errors;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError( $error )
    {
        $this->error = $error;
    }
}