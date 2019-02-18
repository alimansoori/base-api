<?php
namespace Lib\Messages;


interface MessageInterface
{
    /**
     * Returns the message code related to this message
     *
     * @return int
     */
    public function getCode();

    /**
     * Returns field name related to message
     *
     * @return string
     */
    public function getField();

    /**
     * Returns verbose message
     */
    public function getMessage();

	/**
     * Returns message type
     */
	public function getType();

    /**
     * Sets code for the message
     * @param integer $code
     */
	public function setCode($code);

    /**
     * Sets field name related to message
     * @param string $field
     */
	public function setField($field);

    /**
     * Sets verbose message
     * @param string $message
     */
	public function setMessage($message);

    /**
     * Sets message type
     * @param $type
     */
	public function setType($type);

	/**
     * Magic __toString method returns verbose message
     */
	public function __toString();
}