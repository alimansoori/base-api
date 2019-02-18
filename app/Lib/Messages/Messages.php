<?php
namespace Lib\Messages;


use Phalcon\Validation\Message\Group;

class Messages implements \ArrayAccess, \Countable, \Iterator, \JsonSerializable
{
    /** @var int */
    protected $position = 0;
    /** @var array */
    protected $messages = [];

    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    /**
     * Appends a message to the collection
     *
     *<code>
     * $messages->appendMessage(
     *     new \Phalcon\Messages\Message("This is a message")
     * );
     *</code>
     * @param $message
     * @return Messages
     */
    public function appendMessage($message)
	{
	    if(
            $message instanceof \Phalcon\Mvc\Model\MessageInterface ||
            $message instanceof \Phalcon\Validation\MessageInterface
        )
        {
            $newMessage = new Message($message->getMessage(), $message->getField(), $message->getType(), $message->getCode());
            $message = $newMessage;
        }

        if($message instanceof MessageInterface)
            $this->messages[] = $message;

	    return $this;
	}

    /**
     * Appends an array of messages to the collection
     *
     *<code>
     * $messages->appendMessages($messagesArray);
     *</code>
     *
     * @param array messages
     * @throws Exception
     */
    public function appendMessages($messages)
	{
		if (!is_array($messages) && !is_object($messages))
		{
            throw new Exception("The messages must be array or object");
        }

		if (is_array($messages))
		{
		    foreach($messages as $message)
            {
                if(
                    $message instanceof \Phalcon\Mvc\Model\MessageInterface ||
                    $message instanceof \Phalcon\Validation\MessageInterface
                )
                {
                    $this->messages[] = new Message(
                        $message->getMessage(),
                        $message->getField(),
                        $message->getType(),
                        $message->getCode()
                    );
                }
                elseif($message instanceof MessageInterface)
                    $this->messages[] = $message;
            }
        }
		elseif($messages instanceof Messages)
        {

            /**
             * A collection of messages is iterated and appended one-by-one to the current list
             */

            /** @var self $messages */
            $messages->rewind();
            while($messages->valid())
            {
                $message = $messages->current();
                $this->appendMessage($message);
                $messages->next();
            }
		}
        elseif($messages instanceof Group)
        {
            foreach($messages as $message)
            {
                if( $message instanceof \Phalcon\Validation\MessageInterface )
                {
                    $this->messages[] = new Message(
                        $message->getMessage(),
                        $message->getField(),
                        $message->getType(),
                        $message->getCode()
                    );
                }
            }
        }
	}

    /**
     * Filters the message collection by field name
     * @param string $fieldName
     * @return
     */
    public function filter($fieldName)
	{
		$filtered = [];
        $messages = $this->messages;
		if (is_array($messages))
		{

			/**
             * A collection of messages is iterated and appended one-by-one to the current list
             */
			foreach($messages as $message)
			{

				/**
                 * Get the field name
                 */
				if (method_exists($message, "getField")) {
					if($fieldName == $message->getField()) {
						$filtered[] = $message;
					}
                }
            }
        }

        return $filtered;
    }

    /**
     * Returns the current message in the iterator
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->messages[$this->position];
    }

    /**
     * Moves the internal iteration pointer to the next position
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Returns the current position/key in the iterator
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Check if the current message in the iterator is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->messages[$this->position]);
    }

    /**
     * Rewinds the internal iterator
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Checks if an index exists
     *
     *<code>
     * var_dump(
     *     isset($message["database"])
     * );
     *</code>
     *
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param $index
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     * @return bool
     */
    public function offsetExists( $index )
    {
        return isset( $this->messages[ $index]);
    }

    /**
     * Gets an attribute a message using the array syntax
     *
     *<code>
     * print_r(
     *     $messages[0]
     * );
     *</code>
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param $index
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet( $index )
    {
        $returnValue = null;

        if($this->messages[$index])
        {
            $returnValue = $this->messages[$index];
        }

		return $returnValue;
    }

    /**
     * Sets an attribute using the array-syntax
     *
     * <code>
     *  $messages[0] = new \Phalcon\Messages\Message("This is a message");
     * </code>
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param $index
     * @param $message
     * @return void
     * @throws Exception
     * @since 5.0.0
     */
    public function offsetSet( $index, $message )
    {
        if(!is_object($message))
        {
            throw new Exception('The message must be an object');
        }

        $this->messages[$index] = $message;
    }

    /**
     * Removes a message from the list
     *
     * <code>
     *   unset($message["database"]);
     * </code>
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset( $index )
    {
        if(isset($this->messages[$index]))
        {
            array_splice($this->messages, $index, 1);
        }
    }

    /**
     * Returns the number of messages in the list
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->messages);
    }

    /**
     * Returns serialised message objects as array for json_encode. Calls
     * jsonSerialize on each object if present
     *
     *<code>
     * $data = $messages->jsonSerialize();
     * echo json_encode($data);
     *</code>
     *
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
    	$records = [];

    	foreach($this->messages as $message)
    	{
            if (is_object($message) && method_exists($message, "jsonSerialize")) {
                 $records[] = $message->{"jsonSerialize"}();
            } else {
                $records[] = $message;
            }
        }

        return $records;
    }
}