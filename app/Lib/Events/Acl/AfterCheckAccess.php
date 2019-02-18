<?php
namespace Lib\Events\Acl;


use Phalcon\Acl\Adapter\Memory;
use Phalcon\Events\Event;

class AfterCheckAccess
{
    public function __construct(Event $event, Memory $acl)
    {
    }
}