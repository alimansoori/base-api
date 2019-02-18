<?php
namespace Lib\Messages;


class Message implements MessageInterface, \JsonSerializable
{
    /** @var int */
    protected $code;
    /** @var string */
    protected $field;
    /** @var string */
    protected $message;
    /** @var string */
    protected $type;

    /**
     * Lib\Messages\Message constructor
     *
     * @param string $message
     * @param string $field
     * @param string $type
     * @param int $code
     */
    public function __construct($message, $field = '', $type = '', $code = 0)
    {
        $this->message = $message;
        $this->field   = $field;
        $this->type    = $type;
        $this->code    = $code;
    }

    /**
     * Returns the message code related to this message
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns field name related to message
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Returns verbose message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Returns message type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets code for the message
     * @param integer $code
     * @return Message
     */
    public function setCode( $code )
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Sets field name related to message
     * @param string $field
     * @return Message
     */
    public function setField( $field )
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Sets verbose message
     * @param string $message
     * @return Message
     */
    public function setMessage( $message )
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Sets message type
     * @param $type
     * @return Message
     */
    public function setType( $type )
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Magic __toString method returns verbose message
     */
    public function __toString()
    {
        return $this->message;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'field'   => $this->field,
            'message' => $this->message,
            'type'    => $this->type,
            'code'    => $this->code
        ];
    }

    /**
     * Magic __set_state helps to re-build messages variable exporting
     * @param array $message
     * @return Message
     */
    public static function __set_state($message)
	{
		return new self($message["_message"], $message["_field"], $message["_type"], $message["_code"]);
	}
}